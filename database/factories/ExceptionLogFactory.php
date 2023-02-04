<?php

namespace Taecontrol\MoonGuard\Database\Factories;

use Illuminate\Support\Carbon;
use Taecontrol\MoonGuard\Models\ExceptionLog;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExceptionLogFactory extends Factory
{
    protected $model = ExceptionLog::class;

    public function definition(): array
    {
        return [
            'exception_log_group_id' => fn () => ExceptionLogGroup::factory(),
            'message' => $this->faker->word(),
            'type' => $this->faker->word(),
            'file' => $this->faker->word(),
            'line' => $this->faker->randomNumber(),
            'trace' => ['test1', 'test2'],
            'thrown_at' => Carbon::now(),
        ];
    }
}
