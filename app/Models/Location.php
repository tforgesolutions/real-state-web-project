<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'description',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Helper to get full path
    public function getPathAttribute()
    {
        $path = $this->name;
        $current = $this->parent;
        
        while ($current) {
            $path = $current->name . ' > ' . $path;
            $current = $current->parent;
        }
        
        return $path;
    }
}
