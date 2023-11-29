<?php

$channelAccessToken = '0a529ee9559bd50bfadea09e09b9d24c';
$password = '54kink';      // user login password

$bodyMsg = file_get_contents('php://input');

$obj = json_decode($bodyMsg, true);

foreach ($obj['events'] as &$event) {

   $userId = $event['source']['userId'];

   // bot dirty logic
   if (!isset($db['user'][$userId])) {
       if ($event['message']['text'] === $password) {
           $db['user'][$userId] = [
               'userId' => $userId,
               'timestamp' => $event['timestamp']
           ];
           $message = 'Login Success! Wellcome!';
       } else {
           $message = 'Input password please.';
       }
   } else {
       if (strtolower($event['message']['text']) === 'bye') {
           unset($db['user'][$userId]);
           $message = 'bye';
       } else {
           $message = 'Already logged in. You can send \'bye\' to logout.';
       }
   }

   // Make payload
   $payload = [
       'replyToken' => $event['replyToken'],
       'messages' => [
           [
               'type' => 'text',
               'text' => $message
           ]
       ]
   ];

   // Send reply API
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/reply');
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
   
}
