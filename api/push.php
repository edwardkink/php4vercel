<?php

$channelAccessToken = 'zZt3Oq6HAHiv/00n3nMgfAyz4szQZl10OkLuHwTpMmKYzYdumkGe5/dG7i9+W+a7cOLMieegQ+dWDrY830FMGVRlcLzMwvaxogCcyd/SoZXe5PDLgsK+0IWzuRNoyJdSN0UnxanTypx1K20l2nmpdQdB04t89/1O/w1cDnyilFU=';
$userIds = ['U19f1b2bb84dfb7d28cadaeb78d332086'];
$message = isset($argv[1]) ? $argv[1] : 'Hello!';

// make payload
$payload = [
   'to' => $userIds,
   'messages' => [
       [
           'type' => 'text',
           'text' => $message
       ]
   ]
];

// Send Request by CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/multicast');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
   'Content-Type: application/json',
   'Authorization: Bearer ' . $channelAccessToken
]);
$result = curl_exec($ch);
curl_close($ch);
