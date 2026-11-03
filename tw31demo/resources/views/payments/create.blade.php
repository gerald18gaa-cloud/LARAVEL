@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
    <div class="topbar">
        <div>
            <h1>Record Payment</h1>
            <p>Record a payment for a membership transaction.</p>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            Back to Transactions
        </a>
    </div>

    <div class="card form-card">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="membership_transaction_id">
                    Transaction
                </label>

                <select
                    id="membership_transaction_id"
                    name="membership_transaction_id"
                    required
                >
                    <option value="">Select a transaction</option>

                    @foreach ($transactions as $transaction)
                        <option
                            value="{{ $transaction->id }}"
                            @selected(
                                old(
                                    'membership_transaction_id',
                                    $selectedTransaction
                                ) == $transaction->id
                            )
                        >
                            {{ $transaction->reference_number }}
                            -
                            {{ $transaction->member->full_name }}
                            -
                            ₱{{ number_format($transaction->amount, 2) }}
                        </option>
                    @endforeach
                </select>

                @error('membership_transaction_id')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Payment Amount</label>

                <input
                    type="number"
                    id="amount"
                    name="amount"
                    step="0.01"
                    min="0.01"
                    value="{{ old('amount') }}"
                    placeholder="Enter the exact transaction amount"
                    required
                >

                @error('amount')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>

                <select
                    id="payment_method"
                    name="payment_method"
                    required
                >
                    <option value="">Select payment method</option>

                    @foreach ([
                        'Cash',
                        'Bank Transfer',
                        'GCash',
                        'Credit Card',
                        'Debit Card',
                    ] as $method)
                        <option
                            value="{{ $method }}"
                            @selected(old('payment_method') === $method)
                        >
                            {{ $method }}
                        </option>
                    @endforeach
                </select>

                @error('payment_method')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="paid_at">Payment Date and Time</label>

                <input
                    type="datetime-local"
                    id="paid_at"
                    name="paid_at"
                    value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}"
                    required
                >

                @error('paid_at')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>

                <textarea
                    id="notes"
                    name="notes"
                    placeholder="Optional payment notes"
                >{{ old('notes') }}</textarea>

                @error('notes')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn">
                Record Payment
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