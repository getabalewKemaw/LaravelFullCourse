<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

          $request->attributes->set('start_time', microtime(true));
        
        return $next($request);
    }

       public function terminate(Request $request, Response $response)
    {
        $duration = microtime(true) - $request->attributes->get('start_time', microtime(true));
        \Log::info('Request finished', [
            'path' => $request->path(),
            'status' => $response->getStatusCode(),
            'duration' => $duration,
        ]);
    }
}
