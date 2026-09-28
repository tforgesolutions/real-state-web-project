<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'type'];

    /**
     * Get a setting value by key.
     */
    public static function get($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function set($key, $value, $type = 'string')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );

        Cache::forget('setting_' . $key);

        return $setting;
    }

    /**
     * Get all settings as an associative array.
     */
    public static function getAll()
    {
        return Cache::rememberForever('settings_all', function () {
            return self::pluck('value', 'key')->toArray();
        });
    }
    
    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget('settings_all');
            Cache::forget('setting_' . $setting->key);
        });
        
        static::deleted(function ($setting) {
            Cache::forget('settings_all');
            Cache::forget('setting_' . $setting->key);
        });
    }
}
