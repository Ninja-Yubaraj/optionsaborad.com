<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'is_active',
        'activated_till',
        'profile_picture',
        'city',
        'state',
        'gst',
        'company_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getProgramsCountAttribute()
    {
        return $this->programs()->count();
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function searchLogs(): HasMany
    {
        return $this->hasMany(SearchLog::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $role = auth()->user()->role;
        $panelId = $panel->getId();

        if($panelId === 'user') {
            return auth()->user()->is_active == 0 && in_array($role, ['user', 'admin']);
        }

        if($panelId === 'data') {
            return in_array($role, ['data', 'admin']);
        }

        if($panelId === 'admin') {
            return $role === 'admin';
        }

        return false;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        // if ($this->profile_picture) {
        //     return Storage::url($this->profile_picture);
            
        // } else {
        //     return null;
        // }

        return Storage::url('profile-pic-for-all.jpg');
    }

    public function getLogo(): ?string
    {
        if ($this->profile_picture) {
            return Storage::url($this->profile_picture);
            
        } else {
            return "https://optionsaborad.com/images/horizontal.png";
        }
    }
}
