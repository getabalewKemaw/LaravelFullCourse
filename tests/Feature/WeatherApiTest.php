<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use App\Events\WeatherRequested;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    public function test_it_returns_weather_data_successfully()
    {
        Http::fake([
            '*' => Http::response([
                'current_weather' => [
                    'temperature' => 22,
                    'windspeed' => 3.5,
                    'time' => '2025-11-03T10:00'
                ],
            ], 200),
        ]);

        Event::fake();

        $response = $this->postJson('/api/weather', ['city' => 'Addis Ababa']);

        $response->assertStatus(200)
            ->assertJson([
                'city' => 'Addis Ababa',
                'temperature' => 22,
                'windspeed' => 3.5,
            ]);

        Event::assertDispatched(WeatherRequested::class);

        Http::assertSent(function (Request $req) {
            return str_contains($req->url(), 'open-meteo.com');
        });
    }

    public function test_it_handles_connection_error()
    {
        Http::fake([
            '*' => Http::failedConnection(),
        ]);

        $response = $this->postJson('/api/weather', ['city' => 'Lalibela']);
        $response->assertStatus(500)
                 ->assertJson(['error' => 'Connection failed']);
    }

    public function test_it_handles_failed_response()
    {
        Http::fake([
            '*' => Http::response(['error' => 'API down'], 500),
        ]);

        $response = $this->postJson('/api/weather', ['city' => 'Dire Dawa']);
        $response->assertStatus(502);
    }
}
