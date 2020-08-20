<?php

include('vendor/autoload.php');

use Telegram\Bot\Api;

$token = getenv('TELEGRAM_BOT_TOKEN');
$telegram = new Api($token);

$result = $telegram->getWebhookUpdates();
$telegram->sendMessage(['chat_id' => $result['message']["chat"]["id"],
                        'text' => 'hello']);

