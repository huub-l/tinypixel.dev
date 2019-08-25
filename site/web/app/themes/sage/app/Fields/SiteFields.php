<?php

namespace App\Fields;

use \StoutLogic\AcfBuilder\FieldsBuilder;
use \App\Fields\Fields;
use Roots\Acorn\Application;

class SiteFields extends Fields
{
    public static $half = ['ui' => 1, 'width' => 50];

    public function builder()
    {
        return [
            'name'  => 'Site',
            'style' => 'seamless',
            'ui'    => 1,
        ];
    }

    public function fields($builder)
    {
        $builder->addTab('Site', ['placement' => 'left'])

            ->addGroup('hostnames', ['label' => 'Hostnames'])
                ->addUrl('production', ['label' => 'Production hostname', 'wrapper' => ['ui' => 1]])
                ->addUrl('staging', ['label' => 'Staging hostname', 'wrapper' => ['ui' => 1]])
            ->endGroup();

        return $builder;
    }

    public function location()
    {
        return ['post_type', '==', 'site'];
    }
}
