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
        Schema::create('ferry_schedule', function (Blueprint $table) {
            $table->id();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->string('route');
            $table->integer('capacity');
            $table->decimal('price', 8, 2);
            $table->json('days_of_week');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ferry_schedule');
    }
};
