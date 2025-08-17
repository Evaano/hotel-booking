<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_park_ticket_id',
        'park_activity_id',
        'booking_time',
        'num_participants',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'booking_time' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function themeParkTicket()
    {
        return $this->belongsTo(ThemeParkTicket::class);
    }

    public function activity()
    {
        return $this->belongsTo(ParkActivity::class, 'park_activity_id');
    }

    /**
     * Alias matching controller/view usage.
     */
    public function parkActivity()
    {
        return $this->belongsTo(ParkActivity::class, 'park_activity_id');
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}
