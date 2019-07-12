<?php

namespace App\Providers;

use \StoutLogic\AcfBuilder\FieldsBuilder;

use \App\Fields\PluginFields;

use Roots\Acorn\ServiceProvider;

class BuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('builder', FieldsBuilder::class);
    }

    public function boot()
    {
        (new PluginFields($this->app))->init();
    }
}
