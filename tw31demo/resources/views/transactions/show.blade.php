@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
    <div class="topbar">
        <div>
            <h1>Transaction Details</h1>
            <p>View membership transaction information.</p>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            Back to Transactions
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card details-card">

        <div class="details-header">
            <div>
                <span class="detail-label">Reference Number</span>
                <h2>{{ $transaction->reference_number }}</h2>
            </div>

            <span class="status-badge status-{{ strtolower($transaction->status) }}">
                {{ $transaction->status }}
            </span>
        </div>

        <div class="details-grid">
            <div>
                <span class="detail-label">Member</span>
                <strong>{{ $transaction->member->full_name }}</strong>
            </div>

            <div>
                <span class="detail-label">Membership Number</span>
                <strong>{{ $transaction->member->membership_number }}</strong>
            </div>

            <div>
                <span class="detail-label">Transaction Type</span>
                <strong>{{ $transaction->transaction_type }}</strong>
            </div>

            <div>
                <span class="detail-label">Membership Level</span>
                <strong>{{ $transaction->level->name }}</strong>
            </div>

            <div>
                <span class="detail-label">Amount</span>
                <strong>
                    ₱{{ number_format($transaction->amount, 2) }}
                </strong>
            </div>

            <div>
                <span class="detail-label">Transaction Date</span>
                <strong>
                    {{ $transaction->transaction_date->format('M d, Y') }}
                </strong>
            </div>

            <div>
                <span class="detail-label">Expiry Date</span>
                <strong>
                    {{ $transaction->expiry_date?->format('M d, Y') ?? 'Not set' }}
                </strong>
            </div>

            <div>
                <span class="detail-label">Payment Status</span>
                <strong>
                    {{ $transaction->payment ? 'Paid' : 'Not yet paid' }}
                </strong>
            </div>
        </div>

        @if ($transaction->payment)
            <div class="payment-box">
                <h3>Payment Information</h3>

                <p>
                    <strong>Payment Reference:</strong>
                    {{ $transaction->payment->payment_reference }}
                </p>

                <p>
                    <strong>Amount Paid:</strong>
                    ₱{{ number_format($transaction->payment->amount, 2) }}
                </p>

                <p>
                    <strong>Payment Method:</strong>
                    {{ $transaction->payment->payment_method }}
                </p>

                <p>
                    <strong>Paid At:</strong>
                    {{ $transaction->payment->paid_at->format('M d, Y h:i A') }}
                </p>
            </div>
        @else
            <div class="payment-action">
                <h3>Payment Required</h3>

                <p>This transaction has not been paid yet.</p>

                <a
                    href="{{ route('payments.create', [
                        'transaction_id' => $transaction->id
                    ]) }}"
                    class="btn"
                >
                    Record Payment
                </a>
            </div>
        @endif

        <div class="status-update-box">
            <h3>Update Transaction Status</h3>

            <form
                action="{{ route('transactions.update', $transaction) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="status">Status</label>

                    <select id="status" name="status" required>
                        @foreach ([
                            'Pending',
                            'Paid',
                            'Approved',
                            'Expired',
                            'Cancelled',
                        ] as $status)
                            <option
                                value="{{ $status }}"
                                @selected($transaction->status === $status)
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input
                    type="hidden"
                    name="notes"
                    value="{{ $transaction->notes }}"
                >

                <button type="submit" class="btn">
                    Update Status
                </button>
            </form>
        </div>

        @if ($transaction->notes)
            <div class="notes-box">
                <span class="detail-label">Notes</span>
                <p>{{ $transaction->notes }}</p>
            </div>
        @endif

    </div>

    <style>
        .details-card {
            max-width: 900px;
        }

        .details-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .details-header h2 {
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
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            padding-top: 25px;
        }

        .details-grid strong {
            color: #172033;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            color: #92400e;
            background: #fef3c7;
        }

        .status-paid {
            color: #075985;
            background: #e0f2fe;
        }

        .status-approved {
            color: #166534;
            background: #dcfce7;
        }

        .status-expired,
        .status-cancelled {
            color: #991b1b;
            background: #fee2e2;
        }

        .payment-action,
        .payment-box,
        .status-update-box,
        .notes-box {
            margin-top: 28px;
            padding: 18px;
            border-radius: 10px;
        }

        .payment-action {
            background: #f0fdfa;
        }

        .payment-box {
            background: #f0fdf4;
        }

        .status-update-box,
        .notes-box {
            background: #f8fafc;
        }

        .payment-action h3,
        .payment-box h3,
        .status-update-box h3 {
            margin-top: 0;
            color: #0f766e;
        }

        .payment-action p,
        .payment-box p,
        .notes-box p {
            color: #475569;
        }

        .notes-box p {
            margin: 0;
        }

        .status-update-box select {
            max-width: 300px;
        }

        @media (max-width: 600px) {
            .details-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection