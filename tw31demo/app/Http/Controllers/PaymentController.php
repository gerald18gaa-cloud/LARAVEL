<?php

namespace App\Http\Controllers;

use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'transaction.member',
            'transaction.level',
        ])
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $transactions = MembershipTransaction::with([
            'member',
            'level',
        ])
            ->whereIn('status', ['Pending', 'Expired'])
            ->whereDoesntHave('payment')
            ->latest()
            ->get();

        $selectedTransaction = $request->query('transaction_id');

        return view('payments.create', compact(
            'transactions',
            'selectedTransaction'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'membership_transaction_id' => [
                'required',
                'exists:membership_transactions,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'payment_method' => [
                'required',
                Rule::in([
                    'Cash',
                    'Bank Transfer',
                    'GCash',
                    'Credit Card',
                    'Debit Card',
                ]),
            ],

            'paid_at' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $transaction = MembershipTransaction::findOrFail(
            $validated['membership_transaction_id']
        );

        if ($transaction->payment) {
            return back()
                ->withErrors([
                    'membership_transaction_id' =>
                    'This transaction already has a payment.',
                ])
                ->withInput();
        }

        if ((float) $validated['amount'] !== (float) $transaction->amount) {
            return back()
                ->withErrors([
                    'amount' =>
                    'The payment amount must match the transaction amount of ₱'
                        . number_format($transaction->amount, 2),
                ])
                ->withInput();
        }

        DB::transaction(function () use (
            $validated,
            $transaction
        ) {
            Payment::create([
                'membership_transaction_id' =>
                $validated['membership_transaction_id'],

                'payment_reference' =>
                'PAY-' . strtoupper(Str::random(10)),

                'amount' => $validated['amount'],

                'payment_method' =>
                $validated['payment_method'],

                'paid_at' => $validated['paid_at'],

                'notes' => $validated['notes'] ?? null,
            ]);

            $transaction->update([
                'status' => 'Paid',
            ]);
        });

        return redirect()
            ->route('transactions.show', $transaction)
            ->with(
                'success',
                'Payment recorded successfully. Transaction marked as Paid.'
            );
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'transaction.member',
            'transaction.level',
        ]);

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return redirect()
            ->route('payments.show', $payment);
    }

    public function update(
        Request $request,
        Payment $payment
    ) {
        $validated = $request->validate([
            'payment_method' => [
                'required',
                Rule::in([
                    'Cash',
                    'Bank Transfer',
                    'GCash',
                    'Credit Card',
                    'Debit Card',
                ]),
            ],

            'paid_at' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $payment->update($validated);

        return redirect()
            ->route('payments.show', $payment)
            ->with(
                'success',
                'Payment details updated successfully.'
            );
    }

    public function destroy(Payment $payment)
    {
        $transaction = $payment->transaction;

        $payment->delete();

        $transaction->update([
            'status' => 'Pending',
        ]);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with(
                'success',
                'Payment removed. Transaction returned to Pending.'
            );
    }

    public function receipt(Payment $payment)
    {
        $payment->load([
            'transaction.member',
            'transaction.level',
        ]);

        return view('payments.receipt', compact('payment'));
    }
}
