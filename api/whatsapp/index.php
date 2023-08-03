<?php

// Require the Composer autoloader.
require '../../vendor/autoload.php';

use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

// Instantiate the WhatsAppCloudApi super class.
$whatsapp_cloud_api = new WhatsAppCloudApi([
    'from_phone_number_id' => '109747672212218',
    'access_token' => 'EAASzZC83aS7EBO4I0MhKe9hSKN8YShyk17WxGouQj8uXHifiKgNxQ9DVwewJJB5KtaWQt5wzSehuV10N1sz8JNarMVxuTx16oo7GkEE5zCGJIVgNJHPbV0MuP95GmbaB4LGmdTZBzthJs8ZByNZCxltsWMMH0NJ2zutGZBuqzwsl9siZBMsUCwls0jq9gRYj4E3AWygOHwDHdPi6LzHF6jZCjnPcu5q9jxJZCQZDZD',
]);
$msg = '*Seu IngressoZapp Chegou!*
Clique no link: 
https://ingressozapp.com/app/qr.php?codigo=676811';
$whatsapp_cloud_api->sendTextMessage('5567999654445', $msg);