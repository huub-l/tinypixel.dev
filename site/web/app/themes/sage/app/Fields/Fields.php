<?php

namespace App\Fields;

use function \acf_add_options_page;

use Roots\Acorn\Application;

class Fields
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $builder = $this->app->makeWith('builder', $this->builder());

        $builder = $this->fields($builder);

        $builder->setLocation('post_type', '==', 'plugin');

        add_action('acf/init', function () use ($builder) {
            if (function_exists('acf_add_local_field_group')) {
                acf_add_local_field_group($builder);
            }
        });
    }

    public function build()
    {

    }
}
