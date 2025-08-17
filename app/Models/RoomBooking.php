<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in_date',
        'check_out_date',
        'room_type',
        'num_guests',
        'total_amount',
        'booking_status',
        'confirmation_code',
        'payment_status',
        'user_id',
        'room_id',
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->confirmation_code)) {
                $model->confirmation_code = strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function ferryTickets()
    {
        return $this->hasMany(FerryTicket::class);
    }

    public function themeParkTickets()
    {
        return $this->belongsToMany(ThemeParkTicket::class);
    }

    public function isConfirmed(): bool
    {
        return $this->booking_status === 'confirmed';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }

    // Methods for email templates
    public function getBookingType(): string
    {
        return 'Hotel Room Booking';
    }

    public function getEventDate()
    {
        return $this->check_in_date;
    }

    public function getEventTime(): string
    {
        return 'Check-in: '.$this->check_in_date->format('M d, Y').', Check-out: '.$this->check_out_date->format('M d, Y');
    }

    public function getLocation(): string
    {
        return $this->room->hotel->name ?? 'Hotel';
    }

    public function getViewRoute(): string
    {
        return route('bookings.show', $this);
    }
}
