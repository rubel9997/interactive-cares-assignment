<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Rate Limiter configuration
        $this->configureRateLimiting();

        $this->routes(function () {
            // Api v1
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/v1/api.php'));

            // Api v2
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/v2/api.php'));

            // Auth Route
            Route::middleware('api')
                ->prefix('api/auth')
                ->group(base_path('routes/auth.php'));

            // Web Route
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(200)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
