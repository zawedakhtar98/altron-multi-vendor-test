<?php

namespace App\Providers;

use App\Models\User;
use Gate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Passport::ignoreRoutes();
        RateLimiter::for('login_attempts',function(Request $request){
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}

//   Client ID ..................................a135b5ad-3ec9-4130-a5e4-21a1cf91d1fd  
//   Client Secret ..........................wRe81n3ETt6828IV9UlxR4Iv9CzfirVZfrPSNVAr 

//   Client ID .......................... a135c017-4c77-46c7-878e-6651a17009d9  
//   Client Secret ......................eZ1tPzUaIKgOuMzGlmDlUvO2QPC1DmRsMV4915Xh  

