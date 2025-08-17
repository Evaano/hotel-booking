<?php

namespace Database\Seeders;

use App\Models\ActivityBooking;
use App\Models\BeachEvent;
use App\Models\BeachEventBooking;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\ParkActivity;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = User::where('role', 'visitor')->get();
        $rooms = Room::where('status', 'available')->get();
        $ferrySchedules = FerrySchedule::where('status', 'active')->get();
        $activities = ParkActivity::where('status', 'active')->get();
        $beachEvents = BeachEvent::where('status', 'active')->get();

        // Create room bookings (foundation for other bookings)
        $roomBookings = collect();
        for ($i = 0; $i < 15; $i++) {
            $booking = RoomBooking::factory()->create([
                'user_id' => $visitors->random()->id,
                'room_id' => $rooms->random()->id,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
            ]);
            $roomBookings->push($booking);
        }

        // Create ferry tickets based on confirmed room bookings
        foreach ($roomBookings->take(10) as $roomBooking) {
            FerryTicket::factory()->create([
                'user_id' => $roomBooking->user_id,
                'room_booking_id' => $roomBooking->id,
                'ferry_schedule_id' => $ferrySchedules->random()->id,
                'booking_status' => 'confirmed',
            ]);
        }

        // Create theme park tickets based on confirmed room bookings
        $themeParkTickets = collect();
        foreach ($roomBookings->take(8) as $roomBooking) {
            $ticket = ThemeParkTicket::factory()->create([
                'user_id' => $roomBooking->user_id,
                'room_booking_id' => $roomBooking->id,
                'ticket_status' => 'confirmed',
            ]);
            $themeParkTickets->push($ticket);
        }

        // Create activity bookings based on theme park tickets
        foreach ($themeParkTickets as $parkTicket) {
            // Each park ticket holder books 2-4 activities
            for ($i = 0; $i < rand(2, 4); $i++) {
                ActivityBooking::factory()->create([
                    'theme_park_ticket_id' => $parkTicket->id,
                    'park_activity_id' => $activities->random()->id,
                    'status' => 'confirmed',
                ]);
            }
        }

        // Create beach event bookings (independent of hotel bookings)
        foreach ($beachEvents->take(12) as $event) {
            // Each event gets 1-3 bookings
            for ($i = 0; $i < rand(1, 3); $i++) {
                BeachEventBooking::factory()->create([
                    'user_id' => $visitors->random()->id,
                    'beach_event_id' => $event->id,
                    'booking_status' => 'confirmed',
                ]);
            }
        }
    }
}
