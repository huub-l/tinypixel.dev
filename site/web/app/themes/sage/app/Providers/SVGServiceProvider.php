<?php

namespace App\Providers;

use BladeSvg\SvgFactory;
use Illuminate\Support\Collection;
use Roots\Acorn\ServiceProvider;

/**
 * SVG Service Provider
 */
class SVGServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('svg', function () {
            $svg = $this->app['config']->get('svg', []);
            $svgPath = $this->app['config']->get('svg.svg_path');
            $svgSpritesheetPath = $this->app['config']->get('svg.svg_path');

            return new SvgFactory(Collection::make($svg)->merge([
                'svg_path'         => $this->app->basePath($svgPath),
                'spritesheet_path' => $this->app->basePath($svgSpritesheetPath),
            ])->all());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['blade.compiler']->directive('svg', function ($expression) {
            return sprintf('<?= %s(%s); ?>', '\App\Providers\SVGServiceProvider::svgImage', $expression);
        });
    }

    /**
     * Helper to fulfill @svg directives
     */
    public static function svgImage($icon, $class = '', $attrs = [])
    {
        print \Roots\app('svg')->svg($icon, $class, $attrs)->toHtml();
    }
}
