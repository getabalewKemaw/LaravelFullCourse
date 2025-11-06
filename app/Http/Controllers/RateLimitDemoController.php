<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitDemoController extends Controller
{
    public function sendMessage(Request $request)
    {
        // For demo, let's use IP address as unique key
        $key = 'send-message:' . $request->ip();

        // Define rate limit parameters
        $maxAttempts = 5;      // max 5 tries
        $decaySeconds = 60;    // per 1 minute

        // Check if the user exceeded the limit
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => "Too many messages! Try again in {$seconds} seconds."
            ],429);
        }

        // Otherwise, record a new attempt
        RateLimiter::hit($key, $decaySeconds);

        // Simulate a message send
        return response()->json([
            'message' => '✅ Message sent successfully!',
            'remaining_attempts' => RateLimiter::remaining($key, $maxAttempts)
        ]);
    }

    // Optional route to reset (clear) the limiter for testing
    public function reset(Request $request)
    {
        RateLimiter::clear('send-message:' . $request->ip());
        return response()->json(['message' => 'Rate limit reset.']);
    }
}
