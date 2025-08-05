<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class SellerMiddleware
{
    public function handle($request, Closure $next)
    {
        Gate::authorize('access-seller');
        return $next($request);
    }
}
