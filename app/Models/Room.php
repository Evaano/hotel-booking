<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type',
        'description',
        'max_occupancy',
        'base_price',
        'amenities',
        'status',
        'hotel_id',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'amenities' => 'array',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function bookings()
    {
        return $this->hasMany(RoomBooking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('room_type', $type);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function getAmenitiesAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            // Handle double-encoded JSON
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            return $decoded ?? [];
        }
        return $value ?? [];
    }

    public static function getRoomTypes()
    {
        return [
            'standard' => 'Standard Room',
            'deluxe' => 'Deluxe Room', 
            'suite' => 'Suite',
            'family' => 'Family Room',
            'executive' => 'Executive Room',
            'presidential' => 'Presidential Suite',
            'ocean_view' => 'Ocean View Room',
            'garden_view' => 'Garden View Room'
        ];
    }

    public function isAvailableForDates($checkIn, $checkOut)
    {
        return ! $this->bookings()
            ->where('booking_status', 'confirmed')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->exists();
    }
}
