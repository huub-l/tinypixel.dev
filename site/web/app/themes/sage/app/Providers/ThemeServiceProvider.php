<?php

namespace App\Providers;

use App\PostTypes\{
    Plugin,
    Package,
};

use App\Taxonomies\{
    Language,
    Audience,
};

use Illuminate\Support\Collection;
use Roots\Acorn\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * PostTypes
         */
        new Plugin();
        new Package();

        /**
         * Taxonomies
         */
        new Language();
        new Audience();
    }
}
