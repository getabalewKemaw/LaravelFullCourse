<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1️ Run concurrent analytics tasks
        [$users, $orders, $sales] = Concurrency::run([
            fn () => $this->fakeDelay('users'),
            fn () => $this->fakeDelay('orders'),
            fn () => $this->fakeDelay('sales'),
        ]);

        // 2️Send quick response to user
        $response = [
            'total_users' => $users,
            'total_orders' => $orders,
            'total_sales' => $sales,
            'message' => 'Data fetched concurrently 🚀 (logging in background...)',
        ];

        // 3️ Run background jobs AFTER response
        Concurrency::defer([
            fn () => $this->logAnalytics($users, $orders, $sales),
            fn () => $this->notifyMetricsService(),
        ]);

        return response()->json($response);
    }

    private function fakeDelay($type)
    {
        sleep(2);
        return match ($type) {
            'users' => rand(100, 1000),
            'orders' => rand(50, 500),
            'sales' => rand(1000, 5000),
            default => 0,
        };
    }

    private function logAnalytics($users, $orders, $sales)
    {
        // Simulate logging to a file or external service
        sleep(3); // pretend slow logging
        Log::info("Analytics Logged:", [
            'users' => $users,
            'orders' => $orders,
            'sales' => $sales,
            'time' => now(),
        ]);
    }

    private function notifyMetricsService()
    {
        // Simulate background metrics reporting
        sleep(1);
        Log::info("📊 Metrics service notified at " . now());
    }
}
