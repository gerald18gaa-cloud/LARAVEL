@extends('layouts.app')

@section('title', 'Add Membership Level')

@section('content')
    <div class="topbar">
        <div>
            <h1>Add Membership Level</h1>
            <p>Create a membership plan for your members.</p>
        </div>

        <a href="{{ route('levels.index') }}" class="btn btn-secondary">
            Back to Levels
        </a>
    </div>

    <div class="card">
        <form action="{{ route('levels.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Level Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: Gold"
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
                    value="{{ old('fee') }}"
                    min="0"
                    step="0.01"
                    placeholder="Example: 1500.00"
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
                    value="{{ old('validity_months', 12) }}"
                    min="1"
                    placeholder="Example: 12"
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
                    placeholder="Describe the benefits included..."
                >{{ old('benefits') }}</textarea>

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
                    @checked(old('is_active', true))
                >

                <label for="is_active">
                    Active membership level
                </label>
            </div>

            <button type="submit" class="btn">
                Save Level
            </button>
        </form>
    </div>
@endsection