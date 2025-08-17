<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ferry_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_booking_id')->constrained('room_bookings')->onDelete('cascade');
            $table->foreignId('ferry_schedule_id')->constrained('ferry_schedule')->onDelete('cascade');
            $table->date('travel_date');
            $table->integer('num_passengers');
            $table->decimal('total_amount', 8, 2);
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ferry_tickets');
    }
};
