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
            'name'  => 'Plugin',
            'style' => 'seamless',
            'ui'    => 1,
        ];
    }

    public function fields($builder)
    {
        $builder
            ->addTab('Plugin', ['placement' => 'left'])
                ->addGroup('plugin', ['label' => 'Plugin'])
                    ->addText('name', ['label' => 'Plugin name'])
                    ->addUrl('downloadUrl', ['label' => 'Download URL'])
                    ->addTextarea('description', ['label' => 'Plugin description'])
                    ->addText('license', ['label' => 'License', 'placeholder' => 'MIT'])
                    ->addRepeater('requirements', ['label' => 'Requirements'])
                        ->addText('technology', ['label' => 'Technology'])
                        ->addText('version', ['label' => 'Requirement'])
                    ->endRepeater()
                    ->addUrl('sourceCode', ['label' => 'Source'])
                ->endGroup();

        return $builder;
    }

    public function location()
    {
        return ['post_type', '==', 'plugin'];
    }
}
