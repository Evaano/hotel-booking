<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeParkTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_booking_id',
        'visit_date',
        'num_tickets',
        'total_amount',
        'ticket_status',
    ];

    protected $casts = [
        'visit_date' => 'date',
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

    public function activityBookings()
    {
        return $this->hasMany(ActivityBooking::class);
    }

    public function isConfirmed(): bool
    {
        return $this->ticket_status === 'confirmed';
    }

    public function scopeConfirmed($query)
    {
        return $query->where('ticket_status', 'confirmed');
    }
}
