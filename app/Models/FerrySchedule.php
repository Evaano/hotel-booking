<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FerrySchedule extends Model
{
    use HasFactory;

    protected $table = 'ferry_schedule';

    protected $fillable = [
        'departure_time',
        'arrival_time',
        'route',
        'capacity',
        'price',
        'days_of_week',
        'status',
        'operator_id',
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'days_of_week' => 'json',
        'price' => 'decimal:2',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function tickets()
    {
        return $this->hasMany(FerryTicket::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getDaysOfWeekAttribute($value)
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

    public function isAvailableOnDay(string $day): bool
    {
        return in_array(strtolower($day), $this->days_of_week ?? []);
    }
}
