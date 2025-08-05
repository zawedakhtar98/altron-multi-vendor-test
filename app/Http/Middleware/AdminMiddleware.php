<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        Gate::authorize('access-admin');
        return $next($request);
    }
}
