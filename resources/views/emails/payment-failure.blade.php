<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Payment Failure Notification</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            .header {
                background: #ef4444;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 8px 8px 0 0;
            }
            .content {
                background: #fef2f2;
                padding: 20px;
                border-radius: 0 0 8px 8px;
            }
            .payment-details {
                background: white;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
                border-left: 4px solid #ef4444;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                color: #450a0a;
                font-size: 14px;
            }
            .btn {
                display: inline-block;
                padding: 12px 24px;
                background: #ef4444;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                margin: 10px 0;
            }
            .warning {
                background: #fecaca;
                padding: 15px;
                border-radius: 8px;
                margin: 15px 0;
                border-left: 4px solid #ef4444;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>❌ Payment Failed</h1>
            </div>

            <div class="content">
                <h2>Hello {{ $user->name }},</h2>

                <div class="warning">
                    <h3>⚠️ Payment Processing Failed</h3>
                    <p>
                        We were unable to process your payment for the following
                        booking. Please review and try again.
                    </p>
                </div>

                <div class="payment-details">
                    <h3>Booking Information</h3>
                    <p>
                        <strong>Booking ID:</strong>
                        #{{ $booking->id ?? "N/A" }}
                    </p>
                    <p>
                        <strong>Type:</strong>
                        {{ $booking->getBookingType() ?? "N/A" }}
                    </p>
                    <p>
                        <strong>Amount:</strong>
                        ${{ number_format($amount ?? 0, 2) }}
                    </p>
                    <p>
                        <strong>Date:</strong>
                        {{ now()->format("F j, Y g:i A") }}
                    </p>
                    <p>
                        <strong>Status:</strong>
                        <span style="color: #ef4444; font-weight: bold">
                            Payment Failed
                        </span>
                    </p>
                </div>

                <p><strong>Possible Reasons for Payment Failure:</strong></p>
                <ul>
                    <li>Insufficient funds in your account</li>
                    <li>Card has expired or is invalid</li>
                    <li>Billing address doesn't match card details</li>
                    <li>Card has been blocked by your bank</li>
                    <li>Daily transaction limit exceeded</li>
                </ul>

                <p><strong>What You Can Do:</strong></p>
                <ul>
                    <li>Check your payment method and try again</li>
                    <li>Contact your bank to verify the card is active</li>
                    <li>Ensure billing information is correct</li>
                    <li>Try using a different payment method</li>
                    <li>Contact our customer service for assistance</li>
                </ul>

                <p>
                    <strong>Important:</strong>
                    Your booking is not confirmed until payment is successful.
                    Please complete the payment to secure your reservation.
                </p>

                <a href="{{ $retryUrl ?? "#" }}" class="btn">Retry Payment</a>
            </div>

            <div class="footer">
                <p>
                    If you continue to experience issues, please contact our
                    support team.
                </p>
                <p>
                    © {{ date("Y") }} Island Tourism Management System. All
                    rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
