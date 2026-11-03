@extends('layouts.app')

@section('title', 'Payments')

@section('content')
    <div class="topbar">
        <div>
            <h1>Payments</h1>
            <p>View all recorded membership payments.</p>
        </div>

        <a href="{{ route('payments.create') }}" class="btn">
            + Record Payment
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card payment-table-card">
        @if ($payments->count())
            <table>
                <thead>
                    <tr>
                        <th>Payment Reference</th>
                        <th>Transaction</th>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Paid At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>
                                <strong>
                                    {{ $payment->payment_reference }}
                                </strong>
                            </td>

                            <td>
                                {{ $payment->transaction->reference_number }}
                            </td>

                            <td>
                                {{ $payment->transaction->member->full_name }}
                            </td>

                            <td>
                                ₱{{ number_format($payment->amount, 2) }}
                            </td>

                            <td>
                                {{ $payment->payment_method }}
                            </td>

                            <td>
                                {{ $payment->paid_at->format('M d, Y h:i A') }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('payments.show', $payment) }}"
                                    class="btn btn-small"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $payments->links() }}
            </div>
        @else
            <div class="empty-state">
                <h2>No payments recorded</h2>
                <p>Payments will appear here after they are recorded.</p>
            </div>
        @endif
    </div>

    <style>
        .payment-table-card {
            overflow-x: auto;
        }

        .payment-table-card table {
            min-width: 900px;
        }

        .btn-small {
            min-height: 36px;
            padding: 8px 12px;
            font-size: 12px;
        }

        .pagination-wrapper {
            margin-top: 20px;
        }

        .empty-state {
            padding: 45px 20px;
            text-align: center;
        }

        .empty-state h2 {
            margin: 0 0 8px;
        }

        .empty-state p {
            color: #64748b;
        }
    </style>
@endsection