<?php

return [
    [
        'key' => 'abandon_cart',
        'name' => 'abandoncart::app.admin.system.name',
        'sort' => 2
    ], [
        'key' => 'abandon_cart.settings',
        'name' => 'abandoncart::app.admin.system.settings',
        'sort' => 1,
    ], [
        'key' => 'abandon_cart.settings.general',
        'name' => 'abandoncart::app.admin.system.general',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'status',
                'title' => 'abandoncart::app.admin.system.status',
                'type' => 'boolean',
                'channel_based' => true,
                'locale_based' => true
            ]
        ]
    ]
];
