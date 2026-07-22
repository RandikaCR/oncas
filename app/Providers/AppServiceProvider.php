<?php

namespace App\Providers;

use App\Models\PlayerJoinRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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
        URL::forceHttps(app()->isProduction());

        Mail::extend('brevo', function () {
            return (new BrevoTransportFactory)->create(
                new Dsn(
                    'brevo+api',
                    'default',
                    config('services.brevo.key')
                )
            );
        });

        view()->composer('*', function ($view) {

            $themeMode = !empty(session('theme_mode')) ? session('theme_mode') : 'light';
            view()->share('theme_mode', $themeMode);

            if ( request()->segment(1) == 'admin' ){
                // Get User Changes Count
                $joinRequestCount = PlayerJoinRequests::where('is_view', 0)->count();
                view()->share('navJoinRequestCount', $joinRequestCount);

            }

        });
    }
}
