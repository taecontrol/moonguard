<?php

namespace Taecontrol\Larastats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Taecontrol\Larastats\Contracts\LarastatsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Larastats\Database\Factories\UserFactory;

class User extends Model implements LarastatsUser
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
        return config('larastats.notifications.slack.webhook_url');
    }
}
