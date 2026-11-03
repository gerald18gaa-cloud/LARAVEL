@extends('layouts.app')

@section('title', 'New Transaction')

@section('content')
    <div class="topbar">
        <div>
            <h1>New Transaction</h1>
            <p>Create a membership application or renewal.</p>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            Back to Transactions
        </a>
    </div>

    <div class="card form-card">
        <form
            action="{{ route('transactions.store') }}"
            method="POST"
        >
            @csrf

            <div class="form-group">
                <label for="member_id">Member</label>

                <select id="member_id" name="member_id" required>
                    <option value="">Select a member</option>

                    @foreach ($members as $member)
                        <option
                            value="{{ $member->id }}"
                            @selected(
                                old('member_id', $selectedMember) == $member->id
                            )
                        >
                            {{ $member->membership_number }}
                            -
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>

                @error('member_id')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="membership_level_id">
                    Membership Level
                </label>

                <select
                    id="membership_level_id"
                    name="membership_level_id"
                    required
                >
                    <option value="">Select a membership level</option>

                    @foreach ($levels as $level)
                        <option
                            value="{{ $level->id }}"
                            @selected(
                                old('membership_level_id') == $level->id
                            )
                        >
                            {{ $level->name }}
                            -
                            ₱{{ number_format($level->fee, 2) }}
                            /
                            {{ $level->validity_months }} months
                        </option>
                    @endforeach
                </select>

                @error('membership_level_id')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="transaction_type">
                    Transaction Type
                </label>

                <select
                    id="transaction_type"
                    name="transaction_type"
                    required
                >
                    <option value="">Select transaction type</option>

                    <option
                        value="Application"
                        @selected(
                            old('transaction_type') === 'Application'
                        )
                    >
                        New Application
                    </option>

                    <option
                        value="Renewal"
                        @selected(
                            old('transaction_type') === 'Renewal'
                        )
                    >
                        Membership Renewal
                    </option>
                </select>

                @error('transaction_type')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>

                <textarea
                    id="notes"
                    name="notes"
                    placeholder="Optional transaction notes"
                >{{ old('notes') }}</textarea>

                @error('notes')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn">
                Create Transaction
            </button>

            <a
                href="{{ route('transactions.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>
        </form>
    </div>
@endsection