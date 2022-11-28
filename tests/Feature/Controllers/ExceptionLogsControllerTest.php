<?php

namespace Taecontrol\Larastats\Tests\Feature\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Taecontrol\Larastats\Models\Site;
use Taecontrol\Larastats\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Taecontrol\Larastats\Models\ExceptionLogGroup;

class ExceptionLogsControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_stores_exception_logs()
    {
        $site = Site::factory()->create();

        $data = [
            'api_token' => $site->api_token,
            'message' => $this->faker->word(),
            'type' => $this->faker->word(),
            'file' => $this->faker->word(),
            'line' => $this->faker->randomNumber(2),
            'trace' => ['test1', 'test2'],
            'thrown_at' => Carbon::now(),
        ];

        $this->postJson(route('larastats.api.exceptions'), $data)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('success')
                    ->where('success', true)
            );

        $this->assertDatabaseCount('exception_logs', 1);
        $this->assertDatabaseHas('exception_logs', [
            'site_id' => $site->id,
            'message' => $data['message'],
            'type' => $data['type'],
            'line' => $data['line'],
        ]);
    }

    /** @test */
    public function it_creates_an_exception_log_group_if_criteria_is_not_met()
    {
        $site = Site::factory()->create();

        $data = [
            'api_token' => $site->api_token,
            'message' => $this->faker->word(),
            'type' => $this->faker->word(),
            'file' => $this->faker->word(),
            'line' => $this->faker->randomNumber(2),
            'trace' => ['test1', 'test2'],
            'thrown_at' => Carbon::now(),
        ];

        $this->postJson(route('larastats.api.exceptions'), $data)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('success')
                    ->where('success', true)
            );

        ExceptionLogGroup::where('type', $data['type'])->first();

        $this->assertDatabaseCount('exception_log_groups', 1);
        $this->assertDatabaseHas('exception_log_groups', [
            'site_id' => $site->id,
            'message' => $data['message'],
            'type' => $data['type'],
            'line' => $data['line'],
        ]);
    }

    /** @test */
    public function it_updates_an_exception_log_group_when_criteria_is_met()
    {
        $site = Site::factory()->create();

        $data = [
            'api_token' => $site->api_token,
            'message' => $this->faker->word(),
            'type' => $this->faker->word(),
            'file' => $this->faker->word(),
            'line' => $this->faker->randomNumber(2),
            'trace' => ['test1', 'test2'],
            'thrown_at' => now(),
        ];

        $group = ExceptionLogGroup::factory()->create([
            'site_id' => $site->id,
            'message' => 'Hi',
            'file' => $data['file'],
            'type' => $data['type'],
            'line' => $data['line'],
            'first_seen' => now()->subDays(2),
            'last_seen' => now()->subDays(2),
        ])->first();

        $this->postJson(route('larastats.api.exceptions'), $data)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('success')
                    ->where('success', true)
            );

        $group->refresh();

        $this->assertDatabaseCount('exception_log_groups', 1);
        $this->assertDatabaseCount('exception_logs', 1);
        $this->assertDatabaseHas('exception_log_groups', [
            'site_id' => $site->id,
            'message' => $data['message'],
            'type' => $data['type'],
            'file' => $data['file'],
            'line' => $data['line'],
        ]);
        $this->assertEquals($data['thrown_at']->day, $group->last_seen->day);
    }

    /** @test */
    public function all_fields_are_required()
    {
        $this->postJson(route('larastats.api.exceptions'), [])
            ->assertInvalid([
                'api_token' => trans('validation.required', ['attribute' => 'api token']),
                'message' => trans('validation.required', ['attribute' => 'message']),
                'type' => trans('validation.required', ['attribute' => 'type']),
                'line' => trans('validation.required', ['attribute' => 'line']),
                'trace' => trans('validation.required', ['attribute' => 'trace']),
                'thrown_at' => trans('validation.required', ['attribute' => 'thrown at']),
            ]);
    }

    /** @test */
    public function it_returns_not_found_error_if_site_doesnt_exist()
    {
        $data = [
            'api_token' => Str::random(60),
            'message' => $this->faker->word(),
            'type' => $this->faker->word(),
            'file' => $this->faker->word(),
            'line' => $this->faker->randomNumber(2),
            'trace' => ['test1', 'test2'],
            'thrown_at' => Carbon::now(),
        ];

        $this->postJson(route('larastats.api.exceptions'), $data)
            ->assertForbidden();
    }
}
