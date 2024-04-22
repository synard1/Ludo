<?php

return [
    'name' => 'Notification',

    'platform' => [
        'Email' => ['label' => 'Email', 'disabled' => true],
        'Telegram' => ['label' => 'Telegram', 'disabled' => false],
        'WhatsApp' => ['label' => 'WhatsApp', 'disabled' => true],
    ],

    'modules' => [
        'ITSM' => ['Incident', 'Services', 'WorkOrder', 'Logbook'],
        // 'HotspotPortal' => ['Site', 'Ads', 'Client'],
        // Add more modules and sub-modules as needed
    ],
];
