<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(function () {
                    $this->getUserRoutes();
                    $this->getSkillRoutes();
                    $this->getEmployeeRoutes();
                });

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Get the user routes.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    private function getUserRoutes()
    {
        require base_path('routes/api/auth.php');
    }

    /**
     * Get the skill routes.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    private function getSkillRoutes()
    {
        Route::group([
            'middleware' => ['auth:user'],
        ], function () {
            require base_path('routes/api/skills.php');
        });
    }

    /**
     * Get the employee routes.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    private function getEmployeeRoutes()
    {
        Route::group([
            'middleware' => ['auth:user'],
        ], function () {
            require base_path('routes/api/employees.php');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
