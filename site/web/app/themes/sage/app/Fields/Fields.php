<?php

namespace App\Fields;

use function \acf_add_local_field_group;

use Roots\Acorn\Application;

class Fields
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $this->builder = $this->app->makeWith('builder', $this->builder());

        $this->addFields($this->builder);

        $this->setLocation();

        add_action('acf/init', [$this, 'build']);
    }

    public function addFields()
    {
        $this->fields($this->builder);
    }

    public function setLocation()
    {
        $this->builder->setLocation(...$this->location());
    }

    public function build()
    {
        \acf_add_local_field_group($this->builder->build());
    }
}
