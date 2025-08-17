<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\BeachEvent;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class FlowVisitorAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_flow_for_visitor_and_admin(): void
    {
        Carbon::setTestNow('2025-07-01 10:00:00');

        $this->seed();

        $visitor = User::where('role', 'visitor')->firstOrFail();
        $admin = User::where('role', 'admin')->firstOrFail();

        $room = Room::where('status', 'available')->firstOrFail();

        // Visitor creates a hotel room booking
        $checkIn = Carbon::now()->addDays(4)->toDateString();
        $checkOut = Carbon::now()->addDays(7)->toDateString();

        $createBookingResponse = $this->actingAs($visitor)
            ->post(route('bookings.store'), [
                'room_id' => $room->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'num_guests' => 2,
            ]);

        $createBookingResponse->assertRedirect();

        /** @var RoomBooking $booking */
        $booking = RoomBooking::where('user_id', $visitor->id)->latest('id')->firstOrFail();
        $this->assertContains($booking->booking_status, ['pending', 'confirmed']);
        if ($booking->booking_status === 'pending') {
            $this->assertSame('pending', $booking->payment_status);
        }

        // Visitor processes payment for the booking (confirms booking)
        if ($booking->booking_status === 'pending') {
            $paymentResponse = $this->actingAs($visitor)
                ->post(route('bookings.payment', $booking), [
                    'payment_method' => 'credit_card',
                ]);

            $paymentResponse->assertRedirect();
            $booking->refresh();
        }
        $this->assertSame('confirmed', $booking->booking_status);
        $this->assertSame('paid', $booking->payment_status);

        // Visitor books a ferry ticket (requires confirmed hotel booking)
        $this->actingAs($visitor)
            ->get(route('ferry.book-ticket'))
            ->assertOk();

        $schedule = FerrySchedule::where('status', 'active')->firstOrFail();
        $travelDate = $checkIn; // within stay

        $createFerryResponse = $this->actingAs($visitor)
            ->post(route('ferry.store-ticket'), [
                'room_booking_id' => $booking->id,
                'ferry_schedule_id' => $schedule->id,
                'travel_date' => $travelDate,
                'num_passengers' => 2,
            ]);

        $createFerryResponse->assertRedirect();
        /** @var FerryTicket $ferryTicket */
        $ferryTicket = FerryTicket::where('user_id', $visitor->id)->latest('id')->firstOrFail();
        $this->assertContains($ferryTicket->booking_status, ['pending', 'confirmed']);

        // Admin confirms ferry ticket if still pending
        if ($ferryTicket->booking_status === 'pending') {
            $this->actingAs($admin)
                ->post(route('admin.ferry-tickets.confirm', $ferryTicket->id))
                ->assertRedirect();
            $ferryTicket->refresh();
        }
        $this->assertSame('confirmed', $ferryTicket->booking_status);

        // Visitor books a theme park ticket
        $this->actingAs($visitor)
            ->get(route('theme-park.book-ticket'))
            ->assertOk();

        $visitDate = Carbon::parse($checkIn)->addDay()->toDateString();
        $createParkResponse = $this->actingAs($visitor)
            ->post(route('theme-park.store-ticket'), [
                'room_booking_id' => $booking->id,
                'visit_date' => $visitDate,
                'num_tickets' => 3,
            ]);

        $createParkResponse->assertRedirect();
        /** @var ThemeParkTicket $parkTicket */
        $parkTicket = ThemeParkTicket::where('user_id', $visitor->id)->latest('id')->firstOrFail();
        $this->assertContains($parkTicket->ticket_status, ['pending', 'confirmed']);

        // Admin confirms theme park ticket if still pending
        if ($parkTicket->ticket_status === 'pending') {
            $this->actingAs($admin)
                ->post(route('admin.park-tickets.confirm', $parkTicket->id))
                ->assertRedirect();
            $parkTicket->refresh();
        }
        $this->assertSame('confirmed', $parkTicket->ticket_status);

        // Visitor books a beach event
        $event = BeachEvent::where('status', 'active')
            ->where('event_date', '>=', Carbon::now()->addDays(1)->toDateString())
            ->where('start_time', '>=', '12:00')
            ->whereDoesntHave('bookings', function ($q) use ($visitor) {
                $q->where('user_id', $visitor->id)
                  ->whereIn('booking_status', ['pending', 'confirmed']);
            })
            ->orderBy('event_date', 'asc')
            ->firstOrFail();

        $this->actingAs($visitor)
            ->get(route('beach-events.book', $event))
            ->assertOk();

        $createBeachResponse = $this->actingAs($visitor)
            ->post(route('beach-events.store-booking', $event), [
                'num_participants' => 2,
                'special_requirements' => 'N/A',
            ]);

        $createBeachResponse->assertRedirect();
        $this->assertDatabaseHas('beach_event_bookings', [
            'user_id' => $visitor->id,
            'beach_event_id' => $event->id,
        ]);

        $beachBookingId = (int) \DB::table('beach_event_bookings')
            ->where('user_id', $visitor->id)
            ->latest('id')
            ->value('id');

        // Admin confirms beach event booking
        $this->actingAs($admin)
            ->post(route('admin.beach-bookings.confirm', $beachBookingId))
            ->assertRedirect();

        $this->assertDatabaseHas('beach_event_bookings', [
            'id' => $beachBookingId,
            'booking_status' => 'confirmed',
        ]);

        // Visitor views unified My Bookings page
        $this->actingAs($visitor)
            ->get(route('account.bookings'))
            ->assertOk();
    }
}


