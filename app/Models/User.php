<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'phone',
        'profile_photo',
        'business_logo',
        'bio',
        'headline',
        'recruited_by',
        'invite_code',
        'status',
        'trial_ends_at',
        'referral_code',
        'settings',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'website_url',
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
            'trial_ends_at' => 'datetime',
            'suspended_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'settings' => 'array',
        ];
    }

    public function getSetting($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    public function setSetting($key, $value)
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->settings = $settings;
        $this->save();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isConsultant(): bool
    {
        return $this->role === 'consultant';
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruited_by');
    }

    public function recruits()
    {
        return $this->hasMany(User::class, 'recruited_by');
    }
}
