<?php

namespace App\Composers\Concerns;

use Roots\Acorn\Application;
use Illuminate\Support\Collection;

trait Services
{
    /**
     * RememberForever
     */
    protected function forever($key, $closure)
    {
        return $this->cache->rememberForever($key, $closure);
    }

    /**
     * Utilize service providers
     *
     * @param  array $services
     * @return void
     */
    protected function useServices(array $services = []) : void
    {
        Collection::make($services)->each(function ($alias) {
            $callable = Application::getInstance()->make($alias);
            $this->$alias = $callable;
        });
    }
}
