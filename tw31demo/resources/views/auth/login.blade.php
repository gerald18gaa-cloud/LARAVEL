<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Puihaha Membership</title>

    <style>
        :root {
            --navy: #0f172a;
            --teal-dark: #115e59;
            --teal: #0f766e;
            --mint: #99f6e4;
            --text: #172033;
            --muted: #64748b;
            --border: #dbe3ec;
            --background: #f8fafc;
            --danger: #991b1b;
            --danger-bg: #fee2e2;
            --success: #166534;
            --success-bg: #dcfce7;
        }

        * {
            box-sizing: border-box;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            color: var(--text);
            background:
                radial-gradient(
                    circle at top right,
                    rgba(153, 246, 228, 0.65),
                    transparent 32%
                ),
                linear-gradient(135deg, #f8fafc, #ecfeff);
            font-family: Arial, sans-serif;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            width: 100%;
            max-width: 920px;
            min-height: 520px;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 24px;
            background: white;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
        }

        .welcome-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px;
            color: white;
            background:
                linear-gradient(
                    145deg,
                    rgba(15, 23, 42, 0.97),
                    rgba(15, 118, 110, 0.96)
                );
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            margin-bottom: 25px;
            border-radius: 16px;
            color: #134e4a;
            background: var(--mint);
            font-size: 28px;
            font-weight: bold;
        }

        .welcome-panel h1 {
            max-width: 280px;
            margin: 0;
            font-size: 38px;
            line-height: 1.08;
        }

        .welcome-panel p {
            max-width: 300px;
            margin: 18px 0 0;
            color: #ccfbf1;
            line-height: 1.6;
        }

        .welcome-line {
            width: 60px;
            height: 4px;
            margin-top: 30px;
            border-radius: 10px;
            background: var(--mint);
        }

        .login-panel {
            display: flex;
            align-items: center;
            padding: 48px;
            background: white;
        }

        .login-content {
            width: 100%;
            max-width: 390px;
            margin: auto;
        }

        .login-content h2 {
            margin: 0;
            color: var(--navy);
            font-size: 30px;
        }

        .login-description {
            margin: 8px 0 28px;
            color: var(--muted);
            line-height: 1.5;
        }

        .alert {
            padding: 12px 14px;
            margin-bottom: 20px;
            border-radius: 9px;
            font-size: 14px;
        }

        .alert-success {
            color: var(--success);
            background: var(--success-bg);
        }

        .alert-error {
            color: var(--danger);
            background: var(--danger-bg);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            background: #ffffff;
            font: inherit;
            transition: 0.2s ease;
        }

        input::placeholder {
            color: #94a3b8;
        }

        input:focus {
            outline: none;
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
        }

        .login-button {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border: 0;
            border-radius: 9px;
            color: white;
            background: var(--teal);
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .login-button:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
        }

        .security-note {
            margin: 22px 0 0;
            color: var(--muted);
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 700px) {
            body {
                padding: 14px;
            }

            .login-wrapper {
                display: block;
                max-width: 460px;
                min-height: auto;
                border-radius: 18px;
            }

            .welcome-panel {
                align-items: center;
                padding: 32px 24px;
                text-align: center;
            }

            .welcome-panel h1,
            .welcome-panel p {
                max-width: none;
            }

            .welcome-panel h1 {
                font-size: 30px;
            }

            .welcome-line {
                margin-top: 22px;
            }

            .login-panel {
                padding: 32px 24px;
            }

            .login-content h2 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <section class="welcome-panel">
            <div class="logo">P</div>

            <h1>Puihaha Membership</h1>

            <p>
                A simple and organized platform for managing members,
                membership levels, and transactions.
            </p>

            <div class="welcome-line"></div>
        </section>

        <section class="login-panel">
            <div class="login-content">
                <h2>Welcome back</h2>

                <p class="login-description">
                    Sign in to access the administrator dashboard.
                </p>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form
                    action="{{ route('login.submit') }}"
                    method="POST"
                >
                    @csrf

                    <div class="form-group">
                        <label for="email">Email address</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="login-button"
                    >
                        Sign In
                    </button>
                </form>

                <p class="security-note">
                    Secure administrator access
                </p>
            </div>
        </section>

    </div>
</body>
</html>