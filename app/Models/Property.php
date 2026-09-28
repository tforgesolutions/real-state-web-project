<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'bathrooms' => 'decimal:1',
        'negotiable' => 'boolean',
        'amenities' => 'array',
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function amenitiesRelation()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_property', 'property_id', 'amenity_id');
    }
}
