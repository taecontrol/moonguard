<?php

namespace Taecontrol\Larastats\Database\Factories;

use Illuminate\Support\Carbon;
use Taecontrol\Larastats\Models\Site;
use Taecontrol\Larastats\Models\ExceptionLog;
use Taecontrol\Larastats\Models\ExceptionLogGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExceptionLogFactory extends Factory
{
    protected $model = ExceptionLog::class;

    public function definition(): array
    {
        $site = Site::factory()->create();

        return [
            'site_id' => $site->id,
            'exception_log_group_id' => ExceptionLogGroup::factory()
                ->create(['site_id' => $site->id]),
            'message' => $this->faker->word(),
            'type' => $this->faker->word(),
            'file' => $this->faker->word(),
            'line' => $this->faker->randomNumber(),
            'trace' => ['test1', 'test2'],
            'thrown_at' => Carbon::now(),
        ];
    }
}
