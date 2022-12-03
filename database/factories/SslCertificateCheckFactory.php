<?php

namespace Taecontrol\Larastats\Database\Factories;

use Taecontrol\Larastats\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Taecontrol\Larastats\Enums\SslCertificateStatus;
use Taecontrol\Larastats\Models\SslCertificateCheck;

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
