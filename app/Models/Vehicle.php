<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'base_cost_per_day' => 'decimal:2',
        'vat_percentage' => 'decimal:2',
        'images' => 'array',
        'year' => 'integer',
        'seats' => 'integer',
        'doors' => 'integer',
        'passengers' => 'integer',
    ];

    public function vehicleClass()
    {
        return $this->belongsTo(VehicleClass::class);
    }

    public function transmission()
    {
        return $this->belongsTo(VehicleTransmission::class);
    }

    public function primaryPickupLocation()
    {
        return $this->belongsTo(Location::class, 'primary_pickup_location_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }
}
