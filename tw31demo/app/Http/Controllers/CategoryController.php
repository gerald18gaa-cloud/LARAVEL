<?php

namespace App\Http\Controllers;

use App\Models\MembershipCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = MembershipCategory::latest()->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:membership_categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        MembershipCategory::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Membership category created successfully.');
    }

    public function show(MembershipCategory $category)
    {
        return redirect()->route('categories.index');
    }

    public function edit(MembershipCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, MembershipCategory $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('membership_categories', 'name')
                    ->ignore($category->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Membership category updated successfully.');
    }

    public function destroy(MembershipCategory $category)
    {
        if ($category->members()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'This category cannot be deleted because members are assigned to it.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Membership category deleted successfully.');
    }
}