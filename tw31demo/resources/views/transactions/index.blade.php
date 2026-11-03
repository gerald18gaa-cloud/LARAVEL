@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
    <div class="topbar">
        <div>
            <h1>Transactions</h1>
            <p>Manage membership applications and renewals.</p>
        </div>

        <a href="{{ route('transactions.create') }}" class="btn">
            + New Transaction
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card transaction-card">
        @if ($transactions->count())
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Member</th>
                        <th>Type</th>
                        <th>Level</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>
                                <strong>
                                    {{ $transaction->reference_number }}
                                </strong>
                            </td>

                            <td>
                                {{ $transaction->member->full_name }}
                            </td>

                            <td>
                                {{ $transaction->transaction_type }}
                            </td>

                            <td>
                                {{ $transaction->level->name }}
                            </td>

                            <td>
                                ₱{{ number_format($transaction->amount, 2) }}
                            </td>

                            <td>
                                <span class="status-badge status-{{ strtolower($transaction->status) }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>

                            <td>
                                {{ $transaction->transaction_date->format('M d, Y') }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('transactions.show', $transaction) }}"
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
                {{ $transactions->links() }}
            </div>
        @else
            <div class="empty-state">
                <h2>No transactions yet</h2>
                <p>Create the first membership application or renewal.</p>

                <a href="{{ route('transactions.create') }}" class="btn">
                    Create Transaction
                </a>
            </div>
        @endif
    </div>

    <style>
        .transaction-card {
            overflow-x: auto;
        }

        .transaction-card table {
            min-width: 950px;
        }

        .btn-small {
            padding: 8px 12px;
            font-size: 13px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
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

        .empty-state {
            padding: 45px 20px;
            text-align: center;
        }

        .empty-state h2 {
            margin: 0 0 8px;
        }

        .empty-state p {
            margin-bottom: 20px;
            color: #64748b;
        }

        .pagination-wrapper {
            margin-top: 20px;
        }
    </style>
@endsection