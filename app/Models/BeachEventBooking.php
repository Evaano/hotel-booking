<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeachEventBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'beach_event_id',
        'num_participants',
        'total_amount',
        'booking_status',
        'special_requirements',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function beachEvent()
    {
        return $this->belongsTo(BeachEvent::class);
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
