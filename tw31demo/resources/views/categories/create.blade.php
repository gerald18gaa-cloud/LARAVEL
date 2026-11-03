@extends('layouts.app')

@section('title', 'Add Membership Category')

@section('content')
    <div class="topbar">
        <div>
            <h1>Add Membership Category</h1>
            <p>Create a new member category.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Back to Categories
        </a>
    </div>

    <div class="card">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Category Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: Student"
                    required
                >

                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Describe this membership category..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', true))
                >

                <label for="is_active">
                    Active category
                </label>
            </div>

            <button type="submit" class="btn">
                Save Category
            </button>
        </form>
    </div>
@endsection