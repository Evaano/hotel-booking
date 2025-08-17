<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Beach Event Confirmation</title>
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
                background: #22c55e;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 8px 8px 0 0;
            }
            .content {
                background: #f0fdf4;
                padding: 20px;
                border-radius: 0 0 8px 8px;
            }
            .event-details {
                background: white;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
                border-left: 4px solid #22c55e;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                color: #14532d;
                font-size: 14px;
            }
            .btn {
                display: inline-block;
                padding: 12px 24px;
                background: #22c55e;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🏖️ Beach Event Confirmation</h1>
            </div>

            <div class="content">
                <h2>Hello {{ $user->name }},</h2>

                <p>
                    Your beach event booking has been confirmed! Get ready for a
                    fantastic day at the beach!
                </p>

                <div class="event-details">
                    <h3>Event Information</h3>
                    <p>
                        <strong>Event:</strong>
                        {{ $booking->beachEvent->name }}
                    </p>
                    <p>
                        <strong>Date:</strong>
                        {{ $booking->beachEvent->event_date->format("F j, Y") }}
                    </p>
                    <p>
                        <strong>Time:</strong>
                        {{ $booking->beachEvent->start_time->format("g:i A") }}
                        - {{ $booking->beachEvent->end_time->format("g:i A") }}
                    </p>
                    <p>
                        <strong>Location:</strong>
                        {{ $booking->beachEvent->location }}
                    </p>
                    <p>
                        <strong>Booking ID:</strong>
                        #{{ $booking->id }}
                    </p>
                    <p>
                        <strong>Number of Guests:</strong>
                        {{ $booking->number_of_guests }}
                    </p>
                    <p>
                        <strong>Total Price:</strong>
                        ${{ number_format($booking->total_price, 2) }}
                    </p>
                </div>

                <p><strong>What's Included:</strong></p>
                <ul>
                    <li>Beach access and facilities</li>
                    <li>Event activities and entertainment</li>
                    <li>Beach equipment (umbrellas, chairs)</li>
                    <li>Refreshments and snacks</li>
                    <li>Professional event staff</li>
                </ul>

                <p><strong>What to Bring:</strong></p>
                <ul>
                    <li>Swimsuit and beach towel</li>
                    <li>Sunscreen and hat</li>
                    <li>Comfortable beach footwear</li>
                    <li>Camera for memories</li>
                    <li>Extra change of clothes</li>
                </ul>

                <p><strong>Important Notes:</strong></p>
                <ul>
                    <li>Check-in 30 minutes before event start</li>
                    <li>Weather-dependent event (rain date available)</li>
                    <li>Parking available on-site</li>
                    <li>Restrooms and changing facilities provided</li>
                </ul>

                <p>
                    If you have any questions or need to make changes, please
                    contact our customer service.
                </p>

                <a href="{{ route("beach-events.bookings") }}" class="btn">
                    View My Bookings
                </a>
            </div>

            <div class="footer">
                <p>We can't wait to see you at the beach!</p>
                <p>
                    © {{ date("Y") }} Island Tourism Management System. All
                    rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
