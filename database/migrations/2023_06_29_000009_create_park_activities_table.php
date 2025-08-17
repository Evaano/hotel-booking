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
        Schema::create('park_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['ride', 'show', 'experience', 'dining', 'shopping']);
            $table->decimal('price', 8, 2);
            $table->integer('capacity')->nullable();
            $table->integer('age_restriction')->nullable();
            $table->integer('height_restriction')->nullable(); // in cm
            $table->integer('duration_minutes')->nullable();
            $table->json('location_coordinates')->nullable(); // {'lat': 0.0, 'lng': 0.0}
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('park_activities');
    }
};
