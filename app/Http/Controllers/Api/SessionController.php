<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class SessionController extends Controller
{
    // Simulate login: store a small user object in session
    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
        if ($v->fails()) return response()->json(['errors' => $v->errors()], 422);

        $user = [
            'id' => rand(1000, 9999),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        // Put user data into session (persistent)
        $request->session()->put('user', $user);

        // Regenerate session id after "login" (security best practice)
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in (session created)',
            'session_id' => $request->session()->getId(),
            'user' => $user,
        ]);
    }

    // Read user data from session
    public function profile(Request $request)
    {
        if (! $request->session()->has('user')) {
            return response()->json(['message' => 'No user in session'], 401);
        }

        $user = $request->session()->get('user');

        return response()->json([
            'message' => 'Session user fetched',
            'session_id' => $request->session()->getId(),
            'user' => $user,
            'current_url' => url()->current(),
            'previous_url' => url()->previous(),
        ]);
    }

    // Logout: invalidate session
    public function logout(Request $request)
    {
        $request->session()->invalidate(); // removes data and regenerates token
        $request->session()->regenerateToken(); // regenerate CSRF token used with web guard

        return response()->json(['message' => 'Logged out — session invalidated']);
    }

    // Regenerate session id only (keep data)
    public function regenerate(Request $request)
    {
        $old = $request->session()->getId();
        $request->session()->regenerate();
        $new = $request->session()->getId();

        return response()->json([
            'message' => 'Session ID regenerated',
            'old_id' => $old,
            'new_id' => $new,
        ]);
    }
    public function invalidate(Request $request)
    {
        $request->session()->invalidate();
        return response()->json(['message' => 'Session invalidated (flushed + new id)']);
    }

    public function addToCart(Request $request)
    {
        $v = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
        ]);
        if ($v->fails()) return response()->json(['errors' => $v->errors()], 422);

        $item = ['product_id' => $request->input('product_id'), 'qty' => $request->input('qty')];

        $request->session()->push('cart.items', $item);
        return response()->json([
            'message' => 'Item added to cart',
            'cart' => $request->session()->get('cart', [])
        ]);
    }

    // View cart
    public function viewCart(Request $request)
    {
        return response()->json([
            'cart' => $request->session()->get('cart', ['items' => []]),
            'count' => count($request->session()->get('cart.items', [])),
        ]);
    }

    // Flash data for next request
    public function flashMessage(Request $request)
    {
        $request->session()->flash('status', $request->input('status', 'ok'));
        // 'now' example: available this request only
        $request->session()->now('immediate', 'now-value');

        return response()->json([
            'message' => 'Flash stored (next request)',
            'status_now' => $request->session()->get('immediate') // immediate available
        ]);
    }

    // Get flash (consumes it after this request)
    public function getFlash(Request $request)
    {
        $status = $request->session()->pull('status', null);
        return response()->json([
            'status' => $status,
            'remaining' => $request->session()->all()
        ]);
    }

    // Put data into session-scoped cache
    public function sessionCachePut(Request $request)
    {
        $key = $request->input('key', 'x');
        $value = $request->input('value', 'v');

        // expires in 5 minutes (session cache uses now+minutes)
        $request->session()->cache()->put($key, $value, now()->addMinutes(5));

        return response()->json(['message' => "Put {$key} in session cache"]);
    }

    // Read from session cache
    public function sessionCacheGet(Request $request)
    {
        $key = $request->input('key', 'x');
        $val = $request->session()->cache()->get($key);
        return response()->json(['key' => $key, 'value' => $val]);
    }

    // Blocked action (demonstrates session locking)
    public function blockedAction(Request $request)
    {
        // Simulate heavy work that must not collide with other requests modifying the session
        sleep(3); // holding the lock for a bit
        $request->session()->increment('blocked.requests', 1);

        return response()->json([
            'message' => 'Blocked action completed',
            'blocked_requests' => $request->session()->get('blocked.requests')
        ]);
    }
}
