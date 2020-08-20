<?php

include('vendor/autoload.php');

use Telegram\Bot\Api;

$token = getenv('TELEGRAM_BOT_TOKEN');
$telegram = new Api($token);

$result = $telegram->getWebhookUpdates();
$telegram->sendMessage(['chat_id' => $result['message']["chat"]["id"],
                        'text' => 'hello']);

$intents = [];
$intents[] = new \App\intents\UnknownIntent($telegram, $result);
/** @var \App\intents\BaseIntent $intent */
foreach ($intents as $intent) {
    if ($intent->isApplied()) {
        return $intent->execute();
    }
}
