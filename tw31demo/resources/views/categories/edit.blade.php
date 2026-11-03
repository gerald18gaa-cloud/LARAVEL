@extends('layouts.app')

@section('title', 'Edit Membership Category')

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit Membership Category</h1>
            <p>Update the category information.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Back to Categories
        </a>
    </div>

    <div class="card">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
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
                >{{ old('description', $category->description) }}</textarea>

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
                    @checked(old('is_active', $category->is_active))
                >

                <label for="is_active">
                    Active category
                </label>
            </div>

            <button type="submit" class="btn">
                Update Category
            </button>
        </form>
    </div>
@endsection