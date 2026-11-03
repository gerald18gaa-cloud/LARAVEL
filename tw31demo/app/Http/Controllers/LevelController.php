<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LevelController extends Controller
{
    public function index()
    {
        $levels = MembershipLevel::latest()->get();

        return view('levels.index', compact('levels'));
    }

    public function create()
    {
        return view('levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:membership_levels,name'],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_months' => ['required', 'integer', 'min:1'],
            'benefits' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        MembershipLevel::create($validated);

        return redirect()
            ->route('levels.index')
            ->with('success', 'Membership level created successfully.');
    }

    public function show(MembershipLevel $level)
    {
        return redirect()->route('levels.index');
    }

    public function edit(MembershipLevel $level)
    {
        return view('levels.edit', compact('level'));
    }

    public function update(Request $request, MembershipLevel $level)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('membership_levels', 'name')
                    ->ignore($level->id),
            ],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_months' => ['required', 'integer', 'min:1'],
            'benefits' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $level->update($validated);

        return redirect()
            ->route('levels.index')
            ->with('success', 'Membership level updated successfully.');
    }

    public function destroy(MembershipLevel $level)
    {
        if ($level->members()->exists()) {
            return redirect()
                ->route('levels.index')
                ->with('error', 'This level cannot be deleted because members are assigned to it.');
        }

        $level->delete();

        return redirect()
            ->route('levels.index')
            ->with('success', 'Membership level deleted successfully.');
    }
}