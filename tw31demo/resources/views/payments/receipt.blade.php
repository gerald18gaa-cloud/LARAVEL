<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Receipt</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            position: relative;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            color: #172033;
            background:
                radial-gradient(circle at 10% 20%, #ccfbf1 0, transparent 28%),
                radial-gradient(circle at 90% 80%, #dbeafe 0, transparent 30%),
                linear-gradient(135deg, #f8fafc, #ecfeff);
            font-family: Arial, sans-serif;
        }

        .receipt {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 700px;
            margin: auto;
            padding: 35px;
            border: 1px solid #dbe5e8;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: 0 18px 45px rgba(15, 118, 110, 0.14);
        }

        .receipt-header {
            padding-bottom: 20px;
            border-bottom: 2px solid #0f766e;
            text-align: center;
        }

        .receipt-header h1 {
            margin: 0;
            color: #0f766e;
            font-size: 27px;
        }

        .receipt-header p {
            margin: 6px 0 0;
            color: #64748b;
        }

        .receipt-title {
            margin: 25px 0;
            color: #0f172a;
            text-align: center;
            font-size: 20px;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-label {
            display: block;
            margin-bottom: 5px;
            color: #64748b;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .detail-value {
            color: #172033;
            font-weight: bold;
        }

        .amount-box {
            margin-top: 25px;
            padding: 20px;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            color: #075985;
            background: #e0f2fe;
            text-align: center;
        }

        .amount-box small {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .amount-box strong {
            font-size: 29px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            text-align: center;
            font-size: 12px;
        }

        .receipt-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }

        .receipt-button {
            padding: 11px 18px;
            border: 0;
            border-radius: 8px;
            color: white;
            background: #0f766e;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .receipt-button:hover {
            background: #115e59;
        }

        .back-button {
            color: #334155;
            background: #e2e8f0;
        }

        .back-button:hover {
            background: #cbd5e1;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }

            .receipt {
                max-width: 100%;
                border: 0;
                box-shadow: none;
            }

            .receipt-actions {
                display: none;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .receipt {
                padding: 23px;
            }

            .details {
                grid-template-columns: 1fr;
            }

            .receipt-actions {
                flex-direction: column;
            }

            .receipt-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Puihaha Membership</h1>
            <p>Membership Management System</p>
        </div>

        <h2 class="receipt-title">Official Payment Receipt</h2>

        <div class="details">
            <div>
                <span class="detail-label">Payment Reference</span>
                <span class="detail-value">
                    {{ $payment->payment_reference }}
                </span>
            </div>

            <div>
                <span class="detail-label">Transaction Reference</span>
                <span class="detail-value">
                    {{ $payment->transaction->reference_number }}
                </span>
            </div>

            <div>
                <span class="detail-label">Member</span>
                <span class="detail-value">
                    {{ $payment->transaction->member->full_name }}
                </span>
            </div>

            <div>
                <span class="detail-label">Membership Number</span>
                <span class="detail-value">
                    {{ $payment->transaction->member->membership_number }}
                </span>
            </div>

            <div>
                <span class="detail-label">Membership Level</span>
                <span class="detail-value">
                    {{ $payment->transaction->level->name }}
                </span>
            </div>

            <div>
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">
                    {{ $payment->payment_method }}
                </span>
            </div>

            <div>
                <span class="detail-label">Paid At</span>
                <span class="detail-value">
                    {{ $payment->paid_at->format('M d, Y h:i A') }}
                </span>
            </div>
        </div>

        <div class="amount-box">
            <small>Amount Paid</small>
            <strong>
                ₱{{ number_format($payment->amount, 2) }}
            </strong>
        </div>

        <div class="footer">
            Thank you for your payment.
        </div>

        <div class="receipt-actions">
            <a
                href="{{ route('payments.show', $payment) }}"
                class="receipt-button back-button"
            >
                Back
            </a>

            <button
                type="button"
                class="receipt-button"
                onclick="window.print()"
            >
                Print Receipt
            </button>
        </div>
    </div>
</body>
</html>