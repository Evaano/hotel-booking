<?php

namespace App\Services;

use App\Models\BeachEventBooking;
use App\Models\FerryTicket;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send booking confirmation email
     */
    public function sendBookingConfirmation(RoomBooking $booking): bool
    {
        try {
            $user = $booking->user;
            $hotel = $booking->room->hotel;

            $data = [
                'user_name' => $user->name,
                'hotel_name' => $hotel->name,
                'room_number' => $booking->room->room_number,
                'check_in_date' => $booking->check_in_date->format('F j, Y'),
                'check_out_date' => $booking->check_out_date->format('F j, Y'),
                'confirmation_code' => $booking->confirmation_code,
                'total_amount' => number_format($booking->total_amount, 2),
                'num_guests' => $booking->num_guests,
            ];

            Mail::send('emails.booking-confirmation', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Hotel Booking Confirmation - Picnic Island');
            });

            Log::info('Booking confirmation email sent', [
                'user_id' => $user->id,
                'booking_id' => $booking->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send booking confirmation email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send ferry ticket confirmation email
     */
    public function sendFerryTicketConfirmation(FerryTicket $ticket): bool
    {
        try {
            $user = $ticket->user;
            $schedule = $ticket->ferrySchedule;
            $hotel = $ticket->roomBooking->room->hotel;

            $data = [
                'user_name' => $user->name,
                'hotel_name' => $hotel->name,
                'departure_time' => $schedule->departure_time,
                'arrival_time' => $schedule->arrival_time,
                'route' => $schedule->route,
                'travel_date' => $ticket->travel_date->format('F j, Y'),
                'num_passengers' => $ticket->num_passengers,
                'total_amount' => number_format($ticket->total_amount, 2),
            ];

            Mail::send('emails.ferry-ticket-confirmation', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Ferry Ticket Confirmation - Picnic Island');
            });

            Log::info('Ferry ticket confirmation email sent', [
                'user_id' => $user->id,
                'ticket_id' => $ticket->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send ferry ticket confirmation email', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send theme park ticket confirmation email
     */
    public function sendThemeParkTicketConfirmation(ThemeParkTicket $ticket): bool
    {
        try {
            $user = $ticket->user;
            $hotel = $ticket->roomBooking->room->hotel;

            $data = [
                'user_name' => $user->name,
                'hotel_name' => $hotel->name,
                'visit_date' => $ticket->visit_date->format('F j, Y'),
                'num_tickets' => $ticket->num_tickets,
                'total_amount' => number_format($ticket->total_amount, 2),
            ];

            Mail::send('emails.theme-park-ticket-confirmation', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Theme Park Ticket Confirmation - Picnic Island');
            });

            Log::info('Theme park ticket confirmation email sent', [
                'user_id' => $user->id,
                'ticket_id' => $ticket->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send theme park ticket confirmation email', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send beach event confirmation email
     */
    public function sendBeachEventConfirmation(BeachEventBooking $booking): bool
    {
        try {
            $user = $booking->user;
            $event = $booking->beachEvent;

            $data = [
                'user_name' => $user->name,
                'event_name' => $event->name,
                'event_date' => $event->event_date->format('F j, Y'),
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'location' => $event->location,
                'num_participants' => $booking->num_participants,
                'total_amount' => number_format($booking->total_amount, 2),
                'special_requirements' => $booking->special_requirements,
            ];

            Mail::send('emails.beach-event-confirmation', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Beach Event Booking Confirmation - Picnic Island');
            });

            Log::info('Beach event confirmation email sent', [
                'user_id' => $user->id,
                'booking_id' => $booking->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send beach event confirmation email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send booking reminder email
     */
    public function sendBookingReminder(RoomBooking $booking): bool
    {
        try {
            $user = $booking->user;
            $hotel = $booking->room->hotel;

            $data = [
                'user_name' => $user->name,
                'hotel_name' => $hotel->name,
                'check_in_date' => $booking->check_in_date->format('F j, Y'),
                'check_out_date' => $booking->check_out_date->format('F j, Y'),
                'confirmation_code' => $booking->confirmation_code,
                'hotel_address' => $hotel->address,
            ];

            Mail::send('emails.booking-reminder', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Upcoming Hotel Stay Reminder - Picnic Island');
            });

            Log::info('Booking reminder email sent', [
                'user_id' => $user->id,
                'booking_id' => $booking->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send booking reminder email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send cancellation confirmation email
     */
    public function sendCancellationConfirmation($booking, string $type): bool
    {
        try {
            $user = $booking->user;
            $subject = '';
            $template = '';
            $data = [];

            switch ($type) {
                case 'hotel':
                    $subject = 'Hotel Booking Cancellation - Picnic Island';
                    $template = 'emails.booking-cancellation';
                    $data = [
                        'user_name' => $user->name,
                        'hotel_name' => $booking->room->hotel->name,
                        'check_in_date' => $booking->check_in_date->format('F j, Y'),
                        'refund_amount' => number_format($booking->total_amount, 2),
                    ];
                    break;

                case 'ferry':
                    $subject = 'Ferry Ticket Cancellation - Picnic Island';
                    $template = 'emails.ferry-ticket-cancellation';
                    $data = [
                        'user_name' => $user->name,
                        'travel_date' => $booking->travel_date->format('F j, Y'),
                        'refund_amount' => number_format($booking->total_amount, 2),
                    ];
                    break;

                case 'theme_park':
                    $subject = 'Theme Park Ticket Cancellation - Picnic Island';
                    $template = 'emails.theme-park-ticket-cancellation';
                    $data = [
                        'user_name' => $user->name,
                        'visit_date' => $booking->visit_date->format('F j, Y'),
                        'refund_amount' => number_format($booking->total_amount, 2),
                    ];
                    break;

                case 'beach_event':
                    $subject = 'Beach Event Cancellation - Picnic Island';
                    $template = 'emails.beach-event-cancellation';
                    $data = [
                        'user_name' => $user->name,
                        'event_name' => $booking->beachEvent->name,
                        'event_date' => $booking->beachEvent->event_date->format('F j, Y'),
                        'refund_amount' => number_format($booking->total_amount, 2),
                    ];
                    break;
            }

            Mail::send($template, $data, function ($message) use ($user, $subject) {
                $message->to($user->email, $user->name)
                    ->subject($subject);
            });

            Log::info('Cancellation confirmation email sent', [
                'user_id' => $user->id,
                'booking_type' => $type,
                'booking_id' => $booking->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send cancellation confirmation email', [
                'booking_id' => $booking->id,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send payment failure notification
     */
    public function sendPaymentFailureNotification($booking, string $type, string $error): bool
    {
        try {
            $user = $booking->user;
            $subject = 'Payment Failed - Picnic Island';

            $data = [
                'user_name' => $user->name,
                'booking_type' => ucfirst(str_replace('_', ' ', $type)),
                'error_message' => $error,
                'amount' => number_format($booking->total_amount, 2),
            ];

            Mail::send('emails.payment-failure', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Payment Failed - Picnic Island');
            });

            Log::info('Payment failure notification email sent', [
                'user_id' => $user->id,
                'booking_type' => $type,
                'booking_id' => $booking->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send payment failure notification email', [
                'booking_id' => $booking->id,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
