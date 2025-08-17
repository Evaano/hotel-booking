<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Theme Park Ticket Confirmation</title>
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
                background: #eab308;
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 8px 8px 0 0;
            }
            .content {
                background: #fefce8;
                padding: 20px;
                border-radius: 0 0 8px 8px;
            }
            .ticket-details {
                background: white;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
                border-left: 4px solid #eab308;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                color: #713f12;
                font-size: 14px;
            }
            .btn {
                display: inline-block;
                padding: 12px 24px;
                background: #eab308;
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
                <h1>🎢 Theme Park Ticket Confirmation</h1>
            </div>

            <div class="content">
                <h2>Hello {{ $user->name }},</h2>

                <p>
                    Your theme park ticket has been successfully booked! Get
                    ready for an amazing adventure!
                </p>

                <div class="ticket-details">
                    <h3>Ticket Information</h3>
                    <p>
                        <strong>Ticket ID:</strong>
                        #{{ $ticket->id }}
                    </p>
                    <p>
                        <strong>Park:</strong>
                        {{ $ticket->theme_park_name ?? "Adventure Island Theme Park" }}
                    </p>
                    <p>
                        <strong>Date:</strong>
                        {{ $ticket->visit_date->format("F j, Y") }}
                    </p>
                    <p>
                        <strong>Type:</strong>
                        {{ $ticket->ticket_type ?? "General Admission" }}
                    </p>
                    <p>
                        <strong>Number of Tickets:</strong>
                        {{ $ticket->num_tickets }}
                    </p>
                    <p>
                        <strong>Price:</strong>
                        ${{ number_format($ticket->total_amount, 2) }}
                    </p>
                    <p>
                        <strong>Valid:</strong>
                        {{ $ticket->visit_date->format("F j, Y") }} (One day
                        only)
                    </p>
                </div>

                <p><strong>What's Included:</strong></p>
                <ul>
                    <li>Access to all major attractions</li>
                    <li>Live entertainment shows</li>
                    <li>Character meet & greets</li>
                    <li>Park map and guide</li>
                </ul>

                <p><strong>Important Information:</strong></p>
                <ul>
                    <li>Park opens at 9:00 AM</li>
                    <li>Bring comfortable walking shoes</li>
                    <li>Some attractions have height restrictions</li>
                    <li>Food and beverages available for purchase</li>
                    <li>Lockers available for personal items</li>
                </ul>

                <p>
                    If you have any questions or need to make changes, please
                    contact our customer service.
                </p>

                <a href="{{ route("theme-park.tickets") }}" class="btn">
                    View My Tickets
                </a>
            </div>

            <div class="footer">
                <p>Have a fantastic time at the theme park!</p>
                <p>
                    © {{ date("Y") }} Island Tourism Management System. All
                    rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
