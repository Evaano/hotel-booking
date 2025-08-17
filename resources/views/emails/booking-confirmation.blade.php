<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Hotel Booking Confirmation - Picnic Island</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 30px;
                text-align: center;
                border-radius: 10px 10px 0 0;
            }
            .content {
                background: #f9f9f9;
                padding: 30px;
                border-radius: 0 0 10px 10px;
            }
            .confirmation-code {
                background: #e8f5e8;
                border: 2px solid #4caf50;
                padding: 15px;
                text-align: center;
                border-radius: 5px;
                margin: 20px 0;
            }
            .confirmation-code h2 {
                color: #4caf50;
                margin: 0;
            }
            .details {
                background: white;
                padding: 20px;
                border-radius: 5px;
                margin: 20px 0;
            }
            .detail-row {
                display: flex;
                justify-content: space-between;
                margin: 10px 0;
                padding: 5px 0;
                border-bottom: 1px solid #eee;
            }
            .footer {
                text-align: center;
                margin-top: 30px;
                color: #666;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>🎉 Booking Confirmed!</h1>
            <p>Your Picnic Island adventure awaits</p>
        </div>

        <div class="content">
            <h2>Hello {{ $user_name }},</h2>

            <p>
                Great news! Your hotel booking has been confirmed. Here are the
                details:
            </p>

            <div class="confirmation-code">
                <h2>Confirmation Code</h2>
                <h1 style="color: #4caf50; margin: 10px 0">
                    {{ $confirmation_code }}
                </h1>
                <p>
                    <strong>
                        Keep this code safe - you'll need it for ferry and theme
                        park tickets!
                    </strong>
                </p>
            </div>

            <div class="details">
                <h3>Booking Details</h3>

                <div class="detail-row">
                    <span><strong>Hotel:</strong></span>
                    <span>{{ $hotel_name }}</span>
                </div>

                <div class="detail-row">
                    <span><strong>Room Number:</strong></span>
                    <span>{{ $room_number }}</span>
                </div>

                <div class="detail-row">
                    <span><strong>Check-in Date:</strong></span>
                    <span>{{ $check_in_date }}</span>
                </div>

                <div class="detail-row">
                    <span><strong>Check-out Date:</strong></span>
                    <span>{{ $check_out_date }}</span>
                </div>

                <div class="detail-row">
                    <span><strong>Number of Guests:</strong></span>
                    <span>{{ $num_guests }}</span>
                </div>

                <div class="detail-row">
                    <span><strong>Total Amount:</strong></span>
                    <span><strong>${{ $total_amount }}</strong></span>
                </div>
            </div>

            <h3>What's Next?</h3>
            <ul>
                <li>
                    <strong>Ferry Tickets:</strong>
                    Book your ferry tickets using this confirmation code
                </li>
                <li>
                    <strong>Theme Park:</strong>
                    Purchase theme park tickets for your stay
                </li>
                <li>
                    <strong>Activities:</strong>
                    Book exciting activities and experiences
                </li>
                <li>
                    <strong>Beach Events:</strong>
                    Join independent beach events (no hotel required)
                </li>
            </ul>

            <p>
                <strong>Important:</strong>
                Please arrive at the hotel with a valid ID and this confirmation
                code.
            </p>

            <p>
                If you have any questions or need to make changes to your
                booking, please contact our support team.
            </p>

            <p>We can't wait to welcome you to Picnic Island!</p>

            <p>
                Best regards,
                <br />
                The Picnic Island Team
            </p>
        </div>

        <div class="footer">
            <p>
                This email was sent to {{ $user_email }}. Please do not reply
                to this email.
            </p>
            <p>For support, contact: support@picnicisland.com</p>
            <p>
                &copy; {{ date("Y") }} Picnic Island Theme Park. All rights
                reserved.
            </p>
        </div>
    </body>
</html>
