@extends('layouts.app')

@section('title', 'Member Profile')

@section('content')
<div class="topbar">
    <div>
        <h1>Member Profile</h1>
        <p>View member information and transaction history.</p>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-secondary">
        Back to Members
    </a>
</div>

<div class="card profile-card">
    <div class="profile-header">
        <div>
            <span class="detail-label">Membership Number</span>
            <h2>{{ $member->membership_number }}</h2>
        </div>

        @if ($member->status === 'Active')
        <span class="badge">Active</span>
        @else
        <span class="badge badge-inactive">Inactive</span>
        @endif
    </div>

    <div class="details-grid">
        <div>
            <span class="detail-label">Full Name</span>
            <strong>{{ $member->full_name }}</strong>
        </div>

        <div>
            <span class="detail-label">Email</span>
            <strong>{{ $member->email ?: 'No email' }}</strong>
        </div>

        <div>
            <span class="detail-label">Phone</span>
            <strong>{{ $member->phone ?: 'No phone number' }}</strong>
        </div>

        <div>
            <span class="detail-label">Category</span>
            <strong>{{ $member->category->name }}</strong>
        </div>

        <div>
            <span class="detail-label">Membership Level</span>
            <strong>{{ $member->level->name }}</strong>
        </div>

        <div>
            <span class="detail-label">Registered Date</span>
            <strong>
                {{ $member->registered_at?->format('M d, Y') ?? 'Not set' }}
            </strong>
        </div>

        <div class="full-width">
            <span class="detail-label">Address</span>
            <strong>{{ $member->address ?: 'No address provided' }}</strong>
        </div>
    </div>

    <div class="profile-actions">
        <a
            href="{{ route('members.edit', $member) }}"
            class="btn btn-secondary">
            Edit Member
        </a>

        <a
            href="{{ route('transactions.create', [
                    'member_id' => $member->id
                ]) }}"
            class="btn">
            New Transaction
        </a>
    </div>
</div>

<div class="card">
    <div class="section-heading">
        <h2>Transaction History</h2>
        <p>All applications, renewals, and payments for this member.</p>
    </div>

    @if ($member->transactions->count())
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Payment</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($member->transactions as $transaction)
                <tr>
                    <td>
                        <strong>
                            {{ $transaction->reference_number }}
                        </strong>
                    </td>

                    <td>{{ $transaction->transaction_type }}</td>

                    <td>{{ $transaction->level->name }}</td>

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
                        @if ($transaction->payment)
                        <span class="badge">Paid</span>
                        @else
                        <span class="badge badge-inactive">
                            Unpaid
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <h3>No transaction history</h3>
        <p>This member has no recorded transactions yet.</p>

        <a
            href="{{ route('transactions.create', [
                        'member_id' => $member->id
                    ]) }}"
            class="btn">
            Create First Transaction
        </a>
    </div>
    @endif
</div>

<style>
    .profile-card {
        width: 100%;
        max-width: none;
    }

    .profile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding-bottom: 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .profile-header h2 {
        margin: 5px 0 0;
        color: #0f172a;
        font-size: clamp(20px, 2vw, 28px);
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
        color: #64748b;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px 40px;
        padding-top: 25px;
    }

    .details-grid strong {
        display: block;
        color: #172033;
        overflow-wrap: anywhere;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .profile-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 28px;
    }

    .section-heading {
        margin-bottom: 20px;
    }

    .section-heading h2 {
        margin: 0;
        color: #0f172a;
        font-size: 22px;
    }

    .section-heading p {
        margin: 6px 0 0;
        color: #64748b;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-wrapper table {
        width: 100%;
        min-width: 850px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        white-space: nowrap;
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
        padding: 40px 15px;
        text-align: center;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #0f172a;
    }

    .empty-state p {
        margin: 0 0 18px;
        color: #64748b;
    }

    @media (max-width: 900px) {
        .details-grid {
            gap: 20px;
        }
    }

    @media (max-width: 650px) {
        .profile-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .details-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .full-width {
            grid-column: auto;
        }

        .profile-actions {
            flex-direction: column;
        }

        .profile-actions .btn {
            width: 100%;
        }

        .empty-state {
            padding: 30px 10px;
        }
    }
</style>
@endsection