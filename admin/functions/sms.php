<?php
/*
 * Send an SMS through MoveSMS using the credentials in config.php.
 * Returns the API response, or null when SMS is not configured or fails.
 */
function send_sms(string $to, string $message)
{
    global $config;

    if (empty($config['sms']['api_key'])) {
        return null;
    }

    $ch = curl_init('https://sms.movesms.co.ke/api/compose?');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'username' => $config['sms']['username'],
            'api_key'  => $config['sms']['api_key'],
            'sender'   => $config['sms']['sender_id'],
            'to'       => $to,
            'message'  => $message,
            'msgtype'  => 5,
            'dlr'      => 0,
        ],
        CURLOPT_TIMEOUT => 15,
    ]);

    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        error_log('SMS failed: ' . curl_error($ch));
        $output = null;
    }
    curl_close($ch);

    return $output;
}
