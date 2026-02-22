<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'is_encrypted'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return config($key, $default);
        }
        
        return $setting->is_encrypted ? Crypt::decryptString($setting->value) : $setting->value;
    }

    public static function set($key, $value, $encrypt = false)
    {
        $encryptedValue = $encrypt ? Crypt::encryptString($value) : $value;
        
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $encryptedValue, 'is_encrypted' => $encrypt]
        );
    }
}
