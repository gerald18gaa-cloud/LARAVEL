@extends('layouts.app')

@section('title', 'Edit Membership Level')

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit Membership Level</h1>
            <p>Update the membership plan details.</p>
        </div>

        <a href="{{ route('levels.index') }}" class="btn btn-secondary">
            Back to Levels
        </a>
    </div>

    <div class="card">
        <form action="{{ route('levels.update', $level) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Level Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $level->name) }}"
                    required
                >

                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fee">Membership Fee</label>

                <input
                    type="number"
                    id="fee"
                    name="fee"
                    value="{{ old('fee', $level->fee) }}"
                    min="0"
                    step="0.01"
                    required
                >

                @error('fee')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="validity_months">Validity Period in Months</label>

                <input
                    type="number"
                    id="validity_months"
                    name="validity_months"
                    value="{{ old('validity_months', $level->validity_months) }}"
                    min="1"
                    required
                >

                @error('validity_months')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="benefits">Benefits</label>

                <textarea
                    id="benefits"
                    name="benefits"
                >{{ old('benefits', $level->benefits) }}</textarea>

                @error('benefits')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', $level->is_active))
                >

                <label for="is_active">
                    Active membership level
                </label>
            </div>

            <button type="submit" class="btn">
                Update Level
            </button>
        </form>
    </div>
@endsection