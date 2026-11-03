@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-heading">
    <div>
        <span class="eyebrow">OVERVIEW</span>
        <h1>Dashboard</h1>
        <p>Welcome to the Puihaha Membership Management System.</p>
    </div>

    <div class="dashboard-date">
        {{ now()->format('F d, Y') }}
    </div>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">♧</div>
        <div>
            <h2>{{ $totalMembers }}</h2>
            <p>Total Members</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success-icon">✓</div>
        <div>
            <h2>{{ $activeMembers }}</h2>
            <p>Active Members</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning-icon">○</div>
        <div>
            <h2>{{ $inactiveMembers }}</h2>
            <p>Inactive Members</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue-icon">▦</div>
        <div>
            <h2>{{ $totalCategories }}</h2>
            <p>Categories</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon gold-icon">★</div>
        <div>
            <h2>{{ $totalLevels }}</h2>
            <p>Membership Levels</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon pending-icon">!</div>
        <div>
            <h2>{{ $pendingTransactions }}</h2>
            <p>Pending Transactions</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon payment-icon">₱</div>
        <div>
            <h2>₱{{ number_format($collectedPayments, 2) }}</h2>
            <p>Collected Payments</p>
        </div>
    </div>
</div>

<div class="section-heading">
    <h2>Quick Management</h2>
    <p>Choose an area to manage your membership records.</p>
</div>

<div class="dashboard-actions">
    <a href="{{ route('members.index') }}" class="dashboard-action">
        <div class="action-icon">♧</div>
        <div>
            <strong>Manage Members</strong>
            <span>Register, view, edit, search, and deactivate members.</span>
        </div>
        <b>→</b>
    </a>

    <a href="{{ route('categories.index') }}" class="dashboard-action">
        <div class="action-icon">▦</div>
        <div>
            <strong>Manage Categories</strong>
            <span>Manage Student, Regular, Senior Citizen, and Corporate.</span>
        </div>
        <b>→</b>
    </a>

    <a href="{{ route('levels.index') }}" class="dashboard-action">
        <div class="action-icon">★</div>
        <div>
            <strong>Manage Membership Levels</strong>
            <span>Manage fees, benefits, and membership validity periods.</span>
        </div>
        <b>→</b>
    </a>
</div>

<style>
    .dashboard-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .eyebrow {
        color: #0f766e;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
    }

    .dashboard-heading h1 {
        margin: 8px 0 0;
        color: #0f172a;
        font-size: 34px;
    }

    .dashboard-heading p,
    .section-heading p {
        margin: 7px 0 0;
        color: #64748b;
    }

    .dashboard-date {
        padding: 11px 15px;
        border: 1px solid #ccfbf1;
        border-radius: 10px;
        color: #0f766e;
        background: #f0fdfa;
        font-size: 13px;
        font-weight: bold;
        white-space: nowrap;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 36px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
        min-height: 84px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        color: white;
        background: #0f766e;
        font-size: 19px;
        font-weight: bold;
    }

    .success-icon { background: #15803d; }
    .warning-icon { background: #d97706; }
    .blue-icon { background: #2563eb; }
    .gold-icon {
        color: #78350f;
        background: #fbbf24;
    }
    .pending-icon { background: #ca8a04; }
    .payment-icon { background: #0891b2; }

    .stat-card h2 {
        margin: 0;
        color: #0f172a;
        font-size: clamp(20px, 2vw, 26px);
        line-height: 1.1;
        white-space: nowrap;
    }

    .stat-card p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.25;
    }

    .section-heading {
        margin-bottom: 16px;
    }

    .section-heading h2 {
        margin: 0;
        color: #0f172a;
        font-size: 21px;
    }

    .dashboard-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .dashboard-action {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        min-width: 0;
        min-height: 145px;
        padding: 22px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        color: #1e293b;
        background: white;
        text-decoration: none;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        transition: 0.2s ease;
    }

    .dashboard-action:hover {
        border-color: #99f6e4;
        transform: translateY(-3px);
        box-shadow: 0 12px 26px rgba(15, 118, 110, 0.12);
    }

    .action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        border-radius: 11px;
        color: #0f766e;
        background: #ccfbf1;
        font-size: 19px;
        font-weight: bold;
    }

    .dashboard-action strong {
        display: block;
        margin-bottom: 7px;
        color: #0f766e;
        font-size: 16px;
        line-height: 1.25;
    }

    .dashboard-action span {
        display: block;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .dashboard-action b {
        margin-left: auto;
        color: #0f766e;
        font-size: 20px;
    }

    @media (max-width: 1200px) {
        .dashboard-stats {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .dashboard-stats,
        .dashboard-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .dashboard-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .dashboard-date {
            width: 100%;
        }

        .dashboard-stats,
        .dashboard-actions {
            grid-template-columns: 1fr;
        }

        .dashboard-heading h1 {
            font-size: 28px;
        }

        .stat-card {
            min-height: 76px;
        }
    }
</style>
@endsection