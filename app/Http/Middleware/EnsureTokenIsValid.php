<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->header('X-API-TOKEN') ?? $request->input('token');
        if ($token !== "my-secret-token") {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'the token is exprired  or invalid token']);
            }
            return redirect('/about-us');

        }
        return $next($request);

    }

}
