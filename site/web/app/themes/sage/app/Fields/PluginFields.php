<?php

namespace App\Fields;

use \StoutLogic\AcfBuilder\FieldsBuilder;
use \App\Fields\Fields;
use Roots\Acorn\Application;

class PluginFields extends Fields
{
    public static $half = ['ui' => 1, 'width' => 50];

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
        $builder->addTab('Info', ['placement' => 'left'])

            ->addGroup('plugin', ['label' => 'Plugin'])
                ->addText('name', ['label' => 'Plugin name', 'wrapper' => self::$half])
                ->addText('githubId', ['label' => 'Github ID', 'wrapper' => self::$half])
                ->addTextarea('description', ['label' => 'Plugin description'])
                ->addRepeater('requirements', ['label' => 'Requirements'])
                    ->addText('technology', ['label' => 'Technology'])
                    ->addText('version', ['label' => 'Requirement'])
                ->endRepeater()
            ->endGroup();

        return $builder;
    }

    public function location()
    {
        return ['post_type', '==', 'plugin'];
    }
}
