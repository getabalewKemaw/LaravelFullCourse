<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Events\UserRegistered;

use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * Handle user registration (POST /api/users)
     * Demonstrates input(), only(), except(), filled(), boolean(), and enum().
     */
    public function store(Request $request): JsonResponse
    {
        // Get all request input
        $allData = $request->all();

        // Get specific inputs safely
        $name = $request->input('name');
        $email = $request->input('email');
        $isActive = $request->boolean('active'); // Converts "yes"/"on"/1 → true

        // Validate minimal data manually (just for example)
        if (!$request->filled('email')) {
            return response()->json(['error' => 'Email is required'], 400);
        } 

        // Log for debugging (simulate storing to DB)
        Log::info('New user registered', [
            'ip' => $request->ip(),
            'name' => $name,
            'email' => $email,
            'active' => $isActive,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => [
                'name' => $name,
                'email' => $email,
                'active' => $isActive,
                'ipP' => $request->ip(),
            ]
        ]);
    }



    /**
     * Handle user query (GET /api/users)
     * Demonstrates query(), path(), url(), fullUrl(), routeIs(), etc.
     */

      public function register(Request $request)
    {
        // Simulate user creation
        $user = [
            'id' => rand(1000, 9999),
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Log creation
        Log::info("✅ User registered: " . $user['email']);

        // Fire the event
        UserRegistered::dispatch($user);

        return response()->json(['message' => 'User registered successfully!']);
    }
    public function index(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $perPage = $request->integer('per_page', 10);

        $url = $request->fullUrl();
        $method = $request->method();
        $host = $request->host();

        return response()->json([
            'method' => $method,
            'url' => $url,
            'host' => $host,
            'query' => [
                'page' => $page,
                'per_page' => $perPage,
            ]
        ]);
    }

    /**
     * Handle a file upload (POST /api/users/upload)
     */
    public function upload(Request $request): JsonResponse
    {
        if (!$request->hasFile('photo')) {
            return response()->json(['error' => 'No photo uploaded'], 400);
        }

        $file = $request->file('photo');
        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        // Store file in storage/app/public/photos
        $path = $file->store('public/photos');

        return response()->json([
            'message' => 'File uploaded successfully!',
            'path' => $path
        ]);
    }

    /**
     * Demonstrates header(), hasHeader(), bearerToken(), and Accept negotiation.
     */
    public function headers(Request $request): JsonResponse
    {
        $hasCustom = $request->hasHeader('X-Custom-Header');
        $customHeader = $request->header('X-Custom-Header', 'not provided');

        $token = $request->bearerToken(); // from Authorization header
        $acceptsJson = $request->accepts(['application/json']);
        $expectsJson = $request->expectsJson();

        return response()->json([
            'headers' => [
                'custom_header_exists' => $hasCustom,
                'custom_header_value' => $customHeader,
                'bearer_token' => $token,
                'accepts_json' => $acceptsJson,
                'expects_json' => $expectsJson,
            ]
        ]);
    }

    /**
     * Demonstrates IPs, prefers(), and all() together
     */
    public function info(Request $request): JsonResponse
    {
        $preferredType = $request->prefers(['application/json', 'text/html']);
        $ips = $request->ips();

        return response()->json([
            'preferred_type' => $preferredType,
            'ips' => $ips,
            'input' => $request->all(),
        ]);
    }
}
