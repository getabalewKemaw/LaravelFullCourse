<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function fetch(Request $request)
    {
        $request->validate(['city' => 'required|string']);

        $city = $request->input('city');

        //  Make HTTP call with error handling
        try {
            $response = Http::timeout(5)
                ->retry(3, 200)
                ->get(env('WEATHER_API_URL'), [
                    'latitude' => 9.01,
                    'longitude' => 38.76,
                    'current_weather' => true,
                ]);

            if ($response->failed()) {
                Log::error('Weather API error', [
                    'url' => $response->effectiveUri(),
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json(['error' => 'Failed to fetch weather data'], 502);
            }

            $data = $response->json();

            // Extract & normalize
            $weather = [
                'city' => $city,
                'temperature' => $data['current_weather']['temperature'] ?? null,
                'windspeed' => $data['current_weather']['windspeed'] ?? null,
                'time' => $data['current_weather']['time'] ?? null,
            ];

            Log::info('Weather fetched successfully', $weather);

            return response()->json($weather);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Weather API connection failed', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Connection failed'], 500);
        }
    }
}
