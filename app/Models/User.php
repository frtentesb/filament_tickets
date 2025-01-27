<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class User extends Authenticatable implements HasAvatar, MustVerifyEmail
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
        'document_number',
        'avatar_url',
        'telephone',
        'is_admin',
        'settings',
        'password',
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
            'is_admin' => 'boolean',
            'settings' => 'json',

        ];
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;

    }


    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    public function ticketresponses(): HasMany
    {
        return $this->hasMany(TicketResponse::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function useraddresses(): HasOne {
        return $this->hasOne(UserAddress::class);
    }
}
