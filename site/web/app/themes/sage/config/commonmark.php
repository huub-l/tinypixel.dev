<?php

return [

    'environment' => [
        'extensions' => true,
    ],

    'converter' => [
        'renderer' => [
            'block_separator' => "\n",
            'inner_separator' => "\n",
            'soft_break'      => "\n",
        ],
        'enable_em'          => true,
        'enable_strong'      => true,
        'use_asterisk'       => true,
        'use_underscore'     => true,
        'html_input'         => 'allow',
        'allow_unsafe_links' => true,
        'max_nesting_level'  => INF,
    ],
];
