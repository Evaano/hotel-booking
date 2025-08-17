<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'amenities',
        'rating',
        'operator_id',
        'status',
    ];

    protected $casts = [
        'amenities' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:1',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(RoomBooking::class, Room::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
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

    /**
     * Generated placeholder image URL for display purposes.
     */
    public function getImageUrlAttribute(): string
    {
        $seed = $this->id ? 'hotel-'.$this->id : 'hotel-'.md5($this->name ?? uniqid());

        return "https://picsum.photos/seed/{$seed}/800/400";
    }
}
