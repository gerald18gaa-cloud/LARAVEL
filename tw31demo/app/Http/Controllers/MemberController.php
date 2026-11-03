<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],

            'category' => [
                'nullable',
                'integer',
                'exists:membership_categories,id',
            ],

            'level' => [
                'nullable',
                'integer',
                'exists:membership_levels,id',
            ],
        ]);

        $members = Member::with([
            'category',
            'level',
        ])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'membership_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereRaw(
                            "CONCAT(first_name, ' ', last_name) LIKE ?",
                            ["%{$search}%"]
                        )
                        ->orWhere(
                            'first_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'last_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        );
                });
            })
            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where(
                    'membership_category_id',
                    $category
                );
            })
            ->when($filters['level'] ?? null, function ($query, $level) {
                $query->where(
                    'membership_level_id',
                    $level
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = MembershipCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = MembershipLevel::where('is_active', true)
            ->orderBy('fee')
            ->get();

        return view('members.index', [
            'members' => $members,
            'search' => $filters['search'] ?? '',
            'selectedCategory' => $filters['category'] ?? '',
            'selectedLevel' => $filters['level'] ?? '',
            'categories' => $categories,
            'levels' => $levels,
        ]);
    }

    public function create()
    {
        $categories = MembershipCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = MembershipLevel::where('is_active', true)
            ->orderBy('fee')
            ->get();

        return view('members.create', compact(
            'categories',
            'levels'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:members,email',
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'membership_category_id' => [
                'required',
                'exists:membership_categories,id',
            ],
            'membership_level_id' => [
                'required',
                'exists:membership_levels,id',
            ],
            'status' => [
                'required',
                Rule::in(['Active', 'Inactive']),
            ],
            'registered_at' => ['nullable', 'date'],
        ]);

        do {
            $membershipNumber =
                'MEM-' . strtoupper(Str::random(8));
        } while (
            Member::where(
                'membership_number',
                $membershipNumber
            )->exists()
        );

        $validated['membership_number'] = $membershipNumber;

        Validator::make($validated, [
            'membership_number' => [
                'required',
                'string',
                'unique:members,membership_number',
            ],
        ])->validate();

        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member registered successfully.');
    }

    public function show(Member $member)
    {
        $member->load([
            'category',
            'level',
            'transactions.level',
            'transactions.payment',
        ]);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $categories = MembershipCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = MembershipLevel::where('is_active', true)
            ->orderBy('fee')
            ->get();

        return view('members.edit', compact(
            'member',
            'categories',
            'levels'
        ));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('members', 'email')
                    ->ignore($member->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'membership_category_id' => [
                'required',
                'exists:membership_categories,id',
            ],
            'membership_level_id' => [
                'required',
                'exists:membership_levels,id',
            ],
            'status' => [
                'required',
                Rule::in(['Active', 'Inactive']),
            ],
            'registered_at' => ['nullable', 'date'],
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->update([
            'status' => 'Inactive',
        ]);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deactivated successfully.');
    }
}
