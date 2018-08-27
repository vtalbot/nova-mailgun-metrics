<?php

namespace TalbotNinja\NovaMailgun;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mailgun\Mailgun;
use TalbotNinja\NovaMailgun\Mailgun\MailgunStatistic;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->publishes([
            __DIR__ . '/../config/nova-mailgun.php' => config_path('nova-mailgun.php'),
        ]);

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-mailgun', __DIR__.'/../dist/js/card.js');
            Nova::style('nova-mailgun', __DIR__.'/../dist/css/card.css');
        });
    }

    /**
     * Register the card's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/nova-mailgun')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Mailgun::class, function () {
            return Mailgun::create(config('nova-mailgun.api_key'));
        });

        $this->app->bind(MailgunStatistic::class, function ($app) {
            return new MailgunStatistic($app->make(Mailgun::class), config('nova-mailgun.domain'));
        });
    }
}
