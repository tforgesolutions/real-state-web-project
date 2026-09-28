<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'image',
        'designation',
        'company',
        'testimonial',
        'rating',
        'status',
        'featured',
        'display_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'featured' => 'boolean',
        'rating' => 'integer',
        'display_order' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->client_name) . '&background=random';
    }
}
