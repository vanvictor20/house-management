<?php
/*
 * Copy this file to config.php and fill in your own values.
 * config.php is git-ignored so real credentials never end up in the repo.
 * Every value can also be supplied through the matching environment variable.
 */
return [
    'db' => [
        'host'     => getenv('DB_HOST') ?: 'localhost',
        'user'     => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'name'     => getenv('DB_NAME') ?: 'Company',
        'port'     => (int) (getenv('DB_PORT') ?: 3306),
    ],

    // Show PHP errors in the browser. Keep false in production.
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),

    // M-Pesa number tenants are asked to pay rent to (used in invoice SMS).
    'mpesa_number' => getenv('MPESA_NUMBER') ?: '',

    // MoveSMS (https://movesms.co.ke) credentials used for tenant notifications.
    // Leave api_key empty to disable SMS sending.
    'sms' => [
        'username'  => getenv('MOVESMS_USERNAME') ?: '',
        'api_key'   => getenv('MOVESMS_API_KEY') ?: '',
        'sender_id' => getenv('MOVESMS_SENDER_ID') ?: 'SMARTLINK',
    ],
];
