@extends('layouts.app')

@section('title', 'Membership Categories')

@section('content')
    <div class="topbar">
        <div>
            <h1>Membership Categories</h1>
            <p>Manage the categories available to members.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn">
            + Add Category
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        @if ($categories->count())
            <table>
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>

                            <td>
                                {{ $category->description ?: 'No description' }}
                            </td>

                            <td>
                                @if ($category->is_active)
                                    <span class="badge">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>

                            <td>
                                {{ $category->created_at->format('M d, Y') }}
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-secondary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('categories.destroy', $category) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this category?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No membership categories have been added yet.</p>

            <a href="{{ route('categories.create') }}" class="btn">
                Add Your First Category
            </a>
        @endif
    </div>
@endsection