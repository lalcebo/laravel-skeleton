<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(Request $request, UrlGenerator $url): void
    {
        // Indicate that models should prevent lazy loading, silently discarding attributes, and accessing missing attributes.
        Model::shouldBeStrict(!$this->app->isProduction());

        // But in production, log the violation instead of throwing an exception.
        if ($this->app->isProduction()) {
            Model::handleLazyLoadingViolationUsing(static function ($model, $relation): void {
                info("Attempted to lazy load [{$relation}] on model [" . $model::class . '].');
            });
        }

        // If we are not in local or behind a reverse proxy with https enabled.
        if ($request->header('X_FORWARDED_PROTO') === 'https') {
            $url->forceScheme('https');
        }
    }
}
