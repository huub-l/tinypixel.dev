<?php

namespace App\Fields;

use \StoutLogic\AcfBuilder\FieldsBuilder;
use Roots\Acorn\Application;

class PluginFields
{
    public function __construct(Application $app)
    {
        $this->app = $app;

        add_action('acf/init', function () {
            acf_add_local_field_group($this->group->build());
        });
    }

    public function init()
    {
        $builder = $this->app->makeWith('builder', [
            'name' => 'Plugin'
        ]);

        $this->group = $this->addFields($builder);
    }

    public function addFields($builder)
    {
        $builder
                ->addTextArea('description', ['label' => 'Plugin description'])
                ->setLocation('post_type', '==', 'plugin');

        return $builder;
    }
}
