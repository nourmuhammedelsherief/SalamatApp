<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAA84oapI0:APA91bFPK5Xd5cL6eIBSO3_OtkvUOlsxSzuSKWav7inmRkinEUNQQFFidUbR62_AyFoaBt3GAJ3_TD-YgZUU-E_ugpJvpLWKZUpBKclx0XwzGopasy7zWnH6xI1mKLPiDMcj55PhVAHW'),
        'sender_id' => env('FCM_SENDER_ID', '1045994054797'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
