<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Ferry Ticket Confirmation</title>
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
                background: #3b82f6;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 8px 8px 0 0;
            }
            .content {
                background: #f8fafc;
                padding: 20px;
                border-radius: 0 0 8px 8px;
            }
            .ticket-details {
                background: white;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
                border-left: 4px solid #3b82f6;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                color: #64748b;
                font-size: 14px;
            }
            .btn {
                display: inline-block;
                padding: 12px 24px;
                background: #3b82f6;
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
                <h1>🚢 Ferry Ticket Confirmation</h1>
            </div>

            <div class="content">
                <h2>Hello {{ $user->name }},</h2>

                <p>
                    Your ferry ticket has been successfully booked! Here are the
                    details:
                </p>

                <div class="ticket-details">
                    <h3>Ticket Information</h3>
                    <p>
                        <strong>Ticket ID:</strong>
                        #{{ $ticket->id }}
                    </p>
                    <p>
                        <strong>Route:</strong>
                        {{ $ticket->ferrySchedule->route }}
                    </p>
                    <p>
                        <strong>Date:</strong>
                        {{ $ticket->ferrySchedule->departure_time->format("F j, Y") }}
                    </p>
                    <p>
                        <strong>Time:</strong>
                        {{ $ticket->ferrySchedule->departure_time->format("g:i A") }}
                    </p>
                    <p>
                        <strong>Number of Passengers:</strong>
                        {{ $ticket->num_passengers }}
                    </p>
                    <p>
                        <strong>Price:</strong>
                        ${{ number_format($ticket->total_amount, 2) }}
                    </p>
                </div>

                <p><strong>Important Notes:</strong></p>
                <ul>
                    <li>Please arrive at least 30 minutes before departure</li>
                    <li>Bring a valid ID for check-in</li>
                    <li>Check-in closes 15 minutes before departure</li>
                    <li>Weather conditions may affect departure times</li>
                </ul>

                <p>
                    If you have any questions or need to make changes, please
                    contact our customer service.
                </p>

                <a href="{{ route("ferry.tickets") }}" class="btn">
                    View My Tickets
                </a>
            </div>

            <div class="footer">
                <p>Thank you for choosing our ferry service!</p>
                <p>
                    © {{ date("Y") }} Island Tourism Management System. All
                    rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
