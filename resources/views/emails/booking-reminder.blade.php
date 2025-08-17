<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Booking Reminder</title>
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
                background: #f59e0b;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 8px 8px 0 0;
            }
            .content {
                background: #fffbeb;
                padding: 20px;
                border-radius: 0 0 8px 8px;
            }
            .booking-details {
                background: white;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
                border-left: 4px solid #f59e0b;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                color: #78350f;
                font-size: 14px;
            }
            .btn {
                display: inline-block;
                padding: 12px 24px;
                background: #f59e0b;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                margin: 10px 0;
            }
            .reminder {
                background: #fef3c7;
                padding: 15px;
                border-radius: 8px;
                margin: 15px 0;
                border-left: 4px solid #f59e0b;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>⏰ Booking Reminder</h1>
            </div>

            <div class="content">
                <h2>Hello {{ $user->name }},</h2>

                <div class="reminder">
                    <h3>🔔 Friendly Reminder</h3>
                    <p>
                        This is a reminder about your upcoming booking. Please
                        review the details below and prepare accordingly.
                    </p>
                </div>

                <div class="booking-details">
                    <h3>Booking Information</h3>
                    <p>
                        <strong>Booking ID:</strong>
                        #{{ $booking->id }}
                    </p>
                    <p>
                        <strong>Type:</strong>
                        {{ $booking->getBookingType() }}
                    </p>
                    <p>
                        <strong>Date:</strong>
                        {{ $booking->getEventDate()->format("F j, Y") }}
                    </p>
                    <p>
                        <strong>Time:</strong>
                        {{ $booking->getEventTime() }}
                    </p>
                    <p>
                        <strong>Location:</strong>
                        {{ $booking->getLocation() }}
                    </p>
                    <p>
                        <strong>Status:</strong>
                        <span style="color: #16a34a; font-weight: bold">
                            Confirmed
                        </span>
                    </p>
                </div>

                <p><strong>Important Reminders:</strong></p>
                <ul>
                    <li>Please arrive on time for your booking</li>
                    <li>Bring any required documents or identification</li>
                    <li>
                        Check weather conditions if it's an outdoor activity
                    </li>
                    <li>Contact us immediately if you need to make changes</li>
                    <li>Review cancellation policy if needed</li>
                </ul>

                <p><strong>Contact Information:</strong></p>
                <p>
                    If you have any questions or need assistance, please contact
                    our customer service team.
                </p>

                <a href="{{ $booking->getViewRoute() }}" class="btn">
                    View Booking Details
                </a>
            </div>

            <div class="footer">
                <p>We look forward to seeing you!</p>
                <p>
                    © {{ date("Y") }} Island Tourism Management System. All
                    rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
