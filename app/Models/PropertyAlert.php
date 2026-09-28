<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'transaction_type',
        'property_type',
        'location',
        'min_price',
        'max_price',
        'min_bedrooms',
        'max_bedrooms',
        'min_bathrooms',
        'max_bathrooms',
        'min_area',
        'max_area',
        'frequency',
        'status',
        'last_notified_at',
    ];

    protected $casts = [
        'last_notified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
