<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = MembershipTransaction::with([
            'member',
            'level',
            'payment',
        ])
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $members = Member::where('status', 'Active')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $levels = MembershipLevel::where('is_active', true)
            ->orderBy('fee')
            ->get();

        $selectedMember = $request->query('member_id');

        return view('transactions.create', compact(
            'members',
            'levels',
            'selectedMember'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => [
                'required',
                'exists:members,id',
            ],

            'membership_level_id' => [
                'required',
                'exists:membership_levels,id',
            ],

            'transaction_type' => [
                'required',
                Rule::in([
                    'Application',
                    'Renewal',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $level = MembershipLevel::findOrFail(
            $validated['membership_level_id']
        );

        $transactionDate = now();

        $validated['reference_number'] =
            'TXN-' . strtoupper(Str::random(10));

        $validated['amount'] = $level->fee;
        $validated['status'] = 'Pending';
        $validated['transaction_date'] = $transactionDate;

        $validated['expiry_date'] = $transactionDate
            ->copy()
            ->addMonths($level->validity_months);

        MembershipTransaction::create($validated);

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Membership transaction created successfully.'
            );
    }

    public function show(MembershipTransaction $transaction)
    {
        $transaction->load([
            'member',
            'level',
            'payment',
        ]);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(MembershipTransaction $transaction)
    {
        return redirect()
            ->route('transactions.show', $transaction);
    }

    public function update(
        Request $request,
        MembershipTransaction $transaction
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'Pending',
                    'Paid',
                    'Approved',
                    'Expired',
                    'Cancelled',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if (
            $validated['status'] === 'Approved'
            && ! $transaction->payment
        ) {
            return back()
                ->withErrors([
                    'status' =>
                    'Only paid transactions can be approved.',
                ])
                ->withInput();
        }

        if (
            $validated['status'] === 'Paid'
            && ! $transaction->payment
        ) {
            return back()
                ->withErrors([
                    'status' =>
                    'Record a payment before marking this transaction as Paid.',
                ])
                ->withInput();
        }

        $transaction->update($validated);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with(
                'success',
                'Transaction updated successfully.'
            );
    }

    public function destroy(MembershipTransaction $transaction)
    {
        $transaction->update([
            'status' => 'Cancelled',
        ]);

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction cancelled successfully.'
            );
    }
}
