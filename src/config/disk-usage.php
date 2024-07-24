<?php

return [
    'quota_threshold' => [
        'percentage' => env('DISK_USAGE_THRESHOLD_PERCENTAGE', 80), // Valeur par défaut: 80%
        'absolute' => env('DISK_USAGE_THRESHOLD_ABSOLUTE', 10 * 1024 * 1024 * 1024), // Valeur par défaut: 10 GB
        'notification_email' => env('DISK_USAGE_NOTIFICATION_EMAIL', 'test@example.com'),

    ],
];
