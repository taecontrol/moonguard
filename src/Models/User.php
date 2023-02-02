<?php

namespace Taecontrol\Moonguard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Taecontrol\Moonguard\Contracts\MoonguardUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model implements MoonguardUser
{
    use Notifiable;
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForSlack(): string
    {
        return config('moonguard.notifications.slack.webhook_url');
    }
}
