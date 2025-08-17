<?php

namespace App\Services;

use App\Models\BeachEventBooking;
use App\Models\FerryTicket;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process payment for a room booking
     */
    public function processRoomBookingPayment(RoomBooking $booking, string $paymentMethod = 'credit_card'): array
    {
        try {
            // Simulate payment processing
            $paymentResult = $this->simulatePayment($booking->total_amount, $paymentMethod);

            if ($paymentResult['success']) {
                $booking->update([
                    'payment_status' => 'paid',
                    'booking_status' => 'confirmed',
                ]);

                // Update room status
                $booking->room->update(['status' => 'booked']);

                Log::info('Payment processed successfully', [
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_amount,
                    'payment_method' => $paymentMethod,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'transaction_id' => $paymentResult['transaction_id'],
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment failed: '.$paymentResult['message'],
            ];

        } catch (\Exception $e) {
            Log::error('Payment processing error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing error occurred',
            ];
        }
    }

    /**
     * Process payment for ferry ticket
     */
    public function processFerryTicketPayment(FerryTicket $ticket, string $paymentMethod = 'credit_card'): array
    {
        try {
            $paymentResult = $this->simulatePayment($ticket->total_amount, $paymentMethod);

            if ($paymentResult['success']) {
                $ticket->update(['booking_status' => 'confirmed']);

                Log::info('Ferry ticket payment processed', [
                    'ticket_id' => $ticket->id,
                    'amount' => $ticket->total_amount,
                ]);

                return [
                    'success' => true,
                    'message' => 'Ferry ticket payment processed successfully',
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment failed: '.$paymentResult['message'],
            ];

        } catch (\Exception $e) {
            Log::error('Ferry ticket payment error', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing error occurred',
            ];
        }
    }

    /**
     * Process payment for theme park ticket
     */
    public function processThemeParkTicketPayment(ThemeParkTicket $ticket, string $paymentMethod = 'credit_card'): array
    {
        try {
            $paymentResult = $this->simulatePayment($ticket->total_amount, $paymentMethod);

            if ($paymentResult['success']) {
                $ticket->update(['ticket_status' => 'confirmed']);

                Log::info('Theme park ticket payment processed', [
                    'ticket_id' => $ticket->id,
                    'amount' => $ticket->total_amount,
                ]);

                return [
                    'success' => true,
                    'message' => 'Theme park ticket payment processed successfully',
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment failed: '.$paymentResult['message'],
            ];

        } catch (\Exception $e) {
            Log::error('Theme park ticket payment error', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing error occurred',
            ];
        }
    }

    /**
     * Process payment for beach event booking
     */
    public function processBeachEventPayment(BeachEventBooking $booking, string $paymentMethod = 'credit_card'): array
    {
        try {
            $paymentResult = $this->simulatePayment($booking->total_amount, $paymentMethod);

            if ($paymentResult['success']) {
                $booking->update(['booking_status' => 'confirmed']);

                Log::info('Beach event payment processed', [
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_amount,
                ]);

                return [
                    'success' => true,
                    'message' => 'Beach event payment processed successfully',
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment failed: '.$paymentResult['message'],
            ];

        } catch (\Exception $e) {
            Log::error('Beach event payment error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing error occurred',
            ];
        }
    }

    /**
     * Simulate payment processing (replace with actual payment gateway)
     */
    private function simulatePayment(float $amount, string $method): array
    {
        // Simulate 95% success rate
        $success = rand(1, 100) <= 95;

        if ($success) {
            return [
                'success' => true,
                'transaction_id' => 'TXN_'.strtoupper(uniqid()),
                'message' => 'Payment authorized',
            ];
        }

        return [
            'success' => false,
            'message' => 'Insufficient funds',
        ];
    }

    /**
     * Process refund for a booking
     */
    public function processRefund($booking, ?float $refundAmount = null): array
    {
        try {
            $amount = $refundAmount ?? $booking->total_amount;

            // Simulate refund processing
            $refundResult = $this->simulateRefund($amount);

            if ($refundResult['success']) {
                if ($booking instanceof RoomBooking) {
                    $booking->update(['payment_status' => 'refunded']);
                    $booking->room->update(['status' => 'available']);
                } elseif ($booking instanceof FerryTicket) {
                    $booking->update(['booking_status' => 'cancelled']);
                } elseif ($booking instanceof ThemeParkTicket) {
                    $booking->update(['ticket_status' => 'cancelled']);
                } elseif ($booking instanceof BeachEventBooking) {
                    $booking->update(['booking_status' => 'cancelled']);
                }

                Log::info('Refund processed successfully', [
                    'booking_type' => get_class($booking),
                    'booking_id' => $booking->id,
                    'amount' => $amount,
                ]);

                return [
                    'success' => true,
                    'message' => 'Refund processed successfully',
                    'refund_id' => $refundResult['refund_id'],
                ];
            }

            return [
                'success' => false,
                'message' => 'Refund failed: '.$refundResult['message'],
            ];

        } catch (\Exception $e) {
            Log::error('Refund processing error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Refund processing error occurred',
            ];
        }
    }

    /**
     * Simulate refund processing
     */
    private function simulateRefund(float $amount): array
    {
        // Simulate 98% success rate for refunds
        $success = rand(1, 100) <= 98;

        if ($success) {
            return [
                'success' => true,
                'refund_id' => 'REF_'.strtoupper(uniqid()),
                'message' => 'Refund processed',
            ];
        }

        return [
            'success' => false,
            'message' => 'Refund processing error',
        ];
    }
}
