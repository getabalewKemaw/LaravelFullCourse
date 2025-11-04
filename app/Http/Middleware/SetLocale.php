<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->query('lang', config('app.locale'));
        if (in_array($locale, ['en', 'fr', 'am'])) {
            App::setLocale($locale);
        }
        return $next($request);
    }
}
