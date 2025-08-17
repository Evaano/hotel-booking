<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeachEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_type',
        'organizer_id',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'capacity',
        'price',
        'equipment_included',
        'age_restriction',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'equipment_included' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function bookings()
    {
        return $this->hasMany(BeachEventBooking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    public function hasAgeRestriction(): bool
    {
        return ! is_null($this->age_restriction);
    }

    public function isEquipmentIncluded(): bool
    {
        return $this->equipment_included;
    }

    /**
     * Placeholder image for beach events.
     */
    public function getImageUrlAttribute(): string
    {
        $seed = $this->id ? 'event-'.$this->id : 'event-'.md5($this->name ?? uniqid());

        return "https://picsum.photos/seed/{$seed}/800/400";
    }
}
