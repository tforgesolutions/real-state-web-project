<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'starting_price' => 'decimal:2',
        'maximum_price' => 'decimal:2',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
        'amenities' => 'array',
        'images' => 'array',
        'total_units' => 'integer',
        'available_units' => 'integer',
        'sold_units' => 'integer',
    ];

    // Optional relation for future use
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
