<?php

namespace App\Providers;

use Spatie\SslCertificate\SslCertificate;
use Roots\Acorn\ServiceProvider;
use App\Services\SSL;

class SSLServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ssl', function () {
            return SSLCertificate::class;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->performClientHealthChecks();
    }

    /**
     * Do client health checks
     *
     * @return void
     */
    protected function performClientHealthChecks()
    {
        /**
         * Verify SSL certificates.
         */
        (new SSL(
            $this->app->make('ssl'),
            $this->app->make('cache'),
            $this->app->make('mailer.wordpress')
        ))->init();
    }
}
