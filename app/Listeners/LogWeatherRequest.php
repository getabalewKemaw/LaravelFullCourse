<?php

namespace App\Listeners;

use App\Events\WeatherRequested;
use Illuminate\Support\Facades\Log;

class LogWeatherRequest
{
    public function handle(WeatherRequested $event)
    {
        Log::info("Weather requested for city: {$event->city}");
    }
}
