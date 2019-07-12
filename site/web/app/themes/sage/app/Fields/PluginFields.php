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
        ];
    }

    public function fields(FieldsBuilder $builder)
    {
        return $builder
            ->addGroup('plugin', ['label' => 'Plugin'])
                ->addText('name', ['label' => 'Plugin name'])
                ->addTextArea('description', ['label' => 'Plugin description'])
            ->endGroup();
    }
}
