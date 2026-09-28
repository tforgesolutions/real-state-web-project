<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'phone',
        'whatsapp',
        'agency',
        'designation',
        'bio',
        'experience_years',
        'address',
        'city',
        'country',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'website_url',
        'status',
        'is_featured',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function propertyAlerts()
    {
        return $this->hasMany(PropertyAlert::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function assignedInquiries()
    {
        return $this->hasMany(Inquiry::class, 'agent_id');
    }
}
