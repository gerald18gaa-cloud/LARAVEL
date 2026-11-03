<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Puihaha Membership System')</title>

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #115e59;
            --navy: #0f172a;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
            --background: #f8fafc;
            --white: #ffffff;
            --danger: #dc2626;
            --accent: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            overflow-x: hidden;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 0%,
                    rgba(204, 251, 241, 0.7),
                    transparent 28%),
                var(--background);
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 10;
            width: 255px;
            height: 100vh;
            padding: 28px 18px;
            overflow-y: auto;
            color: white;
            background: linear-gradient(180deg,
                    #0f172a 0%,
                    #123f3a 55%,
                    #0f766e 100%);
            box-shadow: 8px 0 30px rgba(15, 23, 42, 0.12);
        }

        .brand {
            display: block;
            position: relative;
            padding: 0 8px 26px 48px;
            margin-bottom: 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            color: white;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.2;
            text-decoration: none;
        }

        .brand::before {
            content: "P";
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            color: #134e4a;
            background: #99f6e4;
            font-size: 18px;
            font-weight: 800;
        }

        .brand span {
            display: block;
            margin-top: 6px;
            color: #ccfbf1;
            font-size: 11px;
            font-weight: normal;
        }

        .nav-label {
            padding: 0 12px;
            margin: 24px 0 10px;
            color: #99f6e4;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-link {
            display: flex;
            align-items: center;
            min-height: 44px;
            padding: 11px 13px;
            margin-bottom: 5px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: #dbeafe;
            font-size: 14px;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            border-color: rgba(153, 246, 228, 0.3);
            color: white;
            background: rgba(20, 184, 166, 0.35);
            box-shadow: 0 8px 18px rgba(15, 118, 110, 0.2);
        }

        .main {
            width: calc(100% - 255px);
            min-width: 0;
            min-height: 100vh;
            margin-left: 255px;
            padding: 38px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            margin: 0;
            color: var(--navy);
            font-size: 30px;
            letter-spacing: -0.5px;
        }

        .topbar p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 15px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 16px;
            border: 0;
            border-radius: 9px;
            color: white;
            background: var(--primary);
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #64748b;
        }

        .btn-danger {
            background: var(--danger);
        }

        .card {
            width: 100%;
            min-width: 0;
            padding: 26px;
            margin-bottom: 22px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.07);
            overflow-x: auto;
        }

        .card:hover {
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1);
        }

        .alert {
            padding: 15px 18px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            border: 1px solid #bbf7d0;
            color: #166534;
            background: #f0fdf4;
        }

        .alert-error {
            border: 1px solid #fecaca;
            color: #991b1b;
            background: #fef2f2;
        }

        table {
            width: 100%;
            min-width: 760px;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            padding: 13px 12px;
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-align: left;
            text-transform: uppercase;
        }

        td {
            padding: 17px 12px;
            border-bottom: 1px solid #edf2f7;
            color: #334155;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f0fdfa;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            color: #166534;
            background: #dcfce7;
            font-size: 11px;
            font-weight: 800;
        }

        .badge-inactive {
            color: #991b1b;
            background: #fee2e2;
        }

        .actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        input,
        textarea,
        select {
            width: 100%;
            max-width: 100%;
            padding: 12px 13px;
            border: 1px solid #d7dee8;
            border-radius: 9px;
            color: var(--text);
            background: white;
            font: inherit;
            transition: 0.2s ease;
        }

        input::placeholder,
        textarea::placeholder {
            color: #94a3b8;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .error-text {
            margin-top: 5px;
            color: var(--danger);
            font-size: 13px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox input {
            width: auto;
        }

        @media (max-width: 950px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                padding: 20px 16px;
            }

            .brand {
                margin-bottom: 20px;
            }

            .main {
                width: 100%;
                margin-left: 0;
                padding: 25px 18px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 20px 12px;
            }

            .topbar h1 {
                font-size: 25px;
            }

            .card {
                padding: 18px;
                border-radius: 14px;
            }

            .btn {
                width: 100%;
            }

            .actions .btn,
            .actions form,
            .actions form button {
                width: 100%;
            }
        }

        .sidebar-logout {
            margin-top: 30px;
            padding: 0 12px;
        }

        .logout-button {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            color: white;
            background: rgba(220, 38, 38, 0.85);
            font: inherit;
            font-size: 14px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #dc2626;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            Puihaha Membership
            <span>Management System</span>
        </a>

        <div class="nav-label">Main Menu</div>

        <a
            href="{{ route('dashboard') }}"
            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a
            href="{{ route('members.index') }}"
            class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
            Members
        </a>

        <a
            href="{{ route('categories.index') }}"
            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            Membership Categories
        </a>

        <a
            href="{{ route('levels.index') }}"
            class="nav-link {{ request()->routeIs('levels.*') ? 'active' : '' }}">
            Membership Levels
        </a>

        <a
            href="{{ route('transactions.index') }}"
            class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            Transactions
        </a>

        <a
            href="{{ route('payments.index') }}"
            class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            Payments
        </a>

        <div class="sidebar-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        @yield('content')
    </main>
</body>

</html>