<?php

namespace App\Fields;

use \StoutLogic\AcfBuilder\FieldsBuilder;
use \App\Fields\Fields;
use Roots\Acorn\Application;

class PluginFields extends Fields
{
    public function builder()
    {
        return [
            'name' => 'Plugin',
            'style' => 'seamless',
            'ui'    => 'true',
        ];
    }

    public function fields(FieldsBuilder $builder)
    {
        return $builder
            ->addTab('Plugin', ['placement' => 'left'])
                ->addGroup('plugin', ['label' => 'Plugin'])
                    ->addText('name', ['label' => 'Plugin name'])
                    ->addUrl('github', ['label' => 'Github'])
                    ->addTextArea('description', ['label' => 'Plugin description'])
                ->endGroup();
    }

    public function location()
    {
        return ['post_type', '==', 'plugin'];
    }
}
