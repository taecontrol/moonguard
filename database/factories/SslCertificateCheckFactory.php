<?php

namespace Taecontrol\Moonguard\Database\Factories;

use Taecontrol\Moonguard\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Taecontrol\Moonguard\Enums\SslCertificateStatus;
use Taecontrol\Moonguard\Models\SslCertificateCheck;

class SslCertificateCheckFactory extends Factory
{
    protected $model = SslCertificateCheck::class;

    public function definition(): array
    {
        return [
            'status' => SslCertificateStatus::NOT_YET_CHECKED,
            'issuer' => $this->faker->word(),
            'expiration_date' => now()->addDays(15),
            'check_failure_reason' => null,

            'site_id' => fn () => Site::factory(),
        ];
    }
}
