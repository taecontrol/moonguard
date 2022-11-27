<?php

namespace Taecontrol\Larastats\Tests\Factories;

use Illuminate\Support\Str;
use Taecontrol\Larastats\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
            'name' => $this->faker->sentence(),
            'max_request_duration_ms' => RequestDuration::from(1000),
            'uptime_check_enabled' => true,
            'ssl_certificate_check_enabled' => true,
            'api_token' => Str::random(60),
        ];
    }
}
