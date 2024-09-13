<?php

return [
    'default_card_info_provider' => 'binlist',
    'card_info_providers' => [
        'binlist' => [
            'class' => \App\Providers\BinlistCardInfoProvider::class,
            'base_uri' => 'https://lookup.binlist.net',
            'method' => 'GET',
            'fields_map' => [
                'country' => 'country.alpha2',
            ]
        ]
    ],
];