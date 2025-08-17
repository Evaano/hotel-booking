<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'capacity',
        'age_restriction',
        'height_restriction',
        'duration_minutes',
        'location_coordinates',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'location_coordinates' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(ActivityBooking::class);
    }

    public function activityBookings()
    {
        return $this->hasMany(ActivityBooking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Placeholder image for activity cards.
     */
    public function getImageUrlAttribute(): string
    {
        $seed = $this->id ? 'activity-'.$this->id : 'activity-'.md5($this->name ?? uniqid());

        return "https://picsum.photos/seed/{$seed}/800/400";
    }

    public function hasAgeRestriction(): bool
    {
        return ! is_null($this->age_restriction);
    }

    public function hasHeightRestriction(): bool
    {
        return ! is_null($this->height_restriction);
    }
}
