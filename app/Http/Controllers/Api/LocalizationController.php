<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    // 1️ Welcome API
    public function welcome()
    {
        return response()->json([
            'message' => __('messages.welcome'),
        ]);
    }

    // 2️ Order API
    public function order(Request $request)
    {
        $orderId = $request->get('id', 1001);
        return response()->json([
            'message' => __('messages.order_success', ['id' => $orderId]),
        ]);
    }

    // 3️ Notification API (pluralization)
    public function notifications(Request $request)
    {
        $count = $request->get('count', 0);
        return response()->json([
            'message' => trans_choice('messages.notifications', $count, ['count' => $count]),
        ]);
    }
}
