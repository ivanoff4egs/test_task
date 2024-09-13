<?php

use App\Providers\BinlistCardInfoProvider;
use App\Providers\ExchangeratesRatesProvider;

return [
    'eu_cards_comission' => 0.01,
    'non_eu_cards_comission' => 0.02,
    'default_card_info_provider' => 'binlist',
    'default_rates_provider' => 'exchangerates',
    'card_info_providers' => [
        'binlist' => [
            'class' => BinlistCardInfoProvider::class,
            'base_uri' => 'https://lookup.binlist.net',
            'method' => 'GET',
        ]
    ],
    'rates_providers' => [
        'exchangerates' => [
            'class' => ExchangeratesRatesProvider::class,
            'access_key' => 'access_key',
            'base_uri' => 'https://api.exchangeratesapi.io/latest',
            'method' => 'GET',
        ],
    ]
];
