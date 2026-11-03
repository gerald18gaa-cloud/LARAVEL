@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="topbar">
    <div>
        <h1>Payment Details</h1>
        <p>View the recorded payment information.</p>
    </div>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
        Back to Payments
    </a>
</div>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card payment-details-card">
    <div class="payment-header">
        <div>
            <span class="detail-label">Payment Reference</span>
            <h2>{{ $payment->payment_reference }}</h2>
        </div>

        <span class="badge">Paid</span>
    </div>

    <div class="details-grid">
        <div>
            <span class="detail-label">Member</span>
            <strong>
                {{ $payment->transaction->member->full_name }}
            </strong>
        </div>

        <div>
            <span class="detail-label">Transaction Reference</span>
            <strong>
                {{ $payment->transaction->reference_number }}
            </strong>
        </div>

        <div>
            <span class="detail-label">Amount Paid</span>
            <strong>
                ₱{{ number_format($payment->amount, 2) }}
            </strong>
        </div>

        <div>
            <span class="detail-label">Payment Method</span>
            <strong>{{ $payment->payment_method }}</strong>
        </div>

        <div>
            <span class="detail-label">Paid At</span>
            <strong>
                {{ $payment->paid_at->format('M d, Y h:i A') }}
            </strong>
        </div>

        <div>
            <span class="detail-label">Membership Level</span>
            <strong>
                {{ $payment->transaction->level->name }}
            </strong>
        </div>
    </div>

    @if ($payment->notes)
    <div class="notes-box">
        <span class="detail-label">Notes</span>
        <p>{{ $payment->notes }}</p>
    </div>
    @endif

    <div class="payment-actions">
        <a
            href="{{ route('payments.receipt', $payment) }}"
            class="btn"
            target="_blank">
            Print Receipt
        </a>

        <a
            href="{{ route(
            'transactions.show',
            $payment->transaction
        ) }}"
            class="btn btn-secondary">
            View Transaction
        </a>

        <form
            action="{{ route('payments.destroy', $payment) }}"
            method="POST"
            onsubmit="return confirm('Remove this payment?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Remove Payment
            </button>
        </form>
    </div>

    <style>
        .payment-details-card {
            width: 100%;
            max-width: 950px;
        }

        .payment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .payment-header h2 {
            margin: 5px 0 0;
            color: #0f172a;
        }

        .detail-label {
            display: block;
            margin-bottom: 6px;
            color: #64748b;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
            padding-top: 25px;
        }

        .details-grid strong {
            color: #172033;
            overflow-wrap: anywhere;
        }

        .notes-box {
            padding: 18px;
            margin-top: 28px;
            border-radius: 10px;
            background: #f8fafc;
        }

        .notes-box p {
            margin: 0;
            color: #475569;
        }

        .payment-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        @media (max-width: 600px) {
            .payment-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .payment-actions .btn,
            .payment-actions form,
            .payment-actions form button {
                width: 100%;
            }
        }
    </style>
    @endsection