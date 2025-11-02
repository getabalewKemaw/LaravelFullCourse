namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;

class AddContext
{
    public function handle(Request $request, Closure $next)
    {
        // Always add URL & unique trace ID
        Context::add('url', $request->url());
        Context::add('trace_id', Str::uuid()->toString());

        // Optionally add user info if logged in
        if (auth()->check()) {
            Context::add('user_id', auth()->id());
        }

        return $next($request);
    }
}
