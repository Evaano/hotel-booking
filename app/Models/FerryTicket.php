<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FerryTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_booking_id',
        'ferry_schedule_id',
        'travel_date',
        'num_passengers',
        'total_amount',
        'booking_status',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roomBooking()
    {
        return $this->belongsTo(RoomBooking::class);
    }

    public function schedule()
    {
        return $this->belongsTo(FerrySchedule::class, 'ferry_schedule_id');
    }

    /**
     * Alias for relation used across controllers/views.
     */
    public function ferrySchedule()
    {
        return $this->belongsTo(FerrySchedule::class, 'ferry_schedule_id');
    }

    public function isConfirmed(): bool
    {
        return $this->booking_status === 'confirmed';
    }

    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }
}
