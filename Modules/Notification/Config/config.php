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

    'bot' => [
        'Telegram' => '6672662128:AAF_FkrdvemSfpXtY9g2IN2HuVLxV1x76dY', // telegram bot secret key, use for company with free versions apps
        // Add more bot config here
    ],


];
