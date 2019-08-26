<?php

namespace App\Providers;

use App\PostTypes\Plugin;
use App\PostTypes\Package;
use App\PostTypes\Site;
use App\Taxonomies\Language;
use App\Taxonomies\Audience;
use App\Services\SSL;
use Illuminate\Support\Collection;
use Roots\Acorn\ServiceProvider;

/**
 * Theme service provider.
 */
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
        $this->registerPostTypes();

        $this->registerTaxonomies();
    }

    /**
     * Register WordPress PostTypes
     *
     * @return void
     */
    protected function registerPostTypes()
    {
        new Plugin();
        new Package();
        new Site();
    }

    /**
     * Register WordPress Taxonomies
     */
    protected function registerTaxonomies()
    {
        new Language();
        new Audience();
    }
}
