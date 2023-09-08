<?php

namespace Taecontrol\MoonGuard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Taecontrol\MoonGuard\Contracts\MoonGuardUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\MoonGuard\Database\Factories\UserFactory;

class User extends Model implements MoonGuardUser
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
        
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
