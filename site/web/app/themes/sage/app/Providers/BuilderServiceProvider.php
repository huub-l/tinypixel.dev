<?php

namespace App\Providers;

use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\PluginFields;
use App\Fields\SiteFields;
use Roots\Acorn\ServiceProvider;

/**
 * Stoutlogic Builder provider
 */
class BuilderServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register()
    {
        $this->app->bind('builder', FieldsBuilder::class);
    }

    /**
     * Boot application services.
     */
    public function boot()
    {
        $pluginFields = new PluginFields($this->app);
        $pluginFields->init();

        $siteFields = new SiteFields($this->app);
        $siteFields->init();
    }
}
