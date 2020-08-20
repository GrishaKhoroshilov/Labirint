<?php

include('vendor/autoload.php');

use Telegram\Bot\Api;

$token = getenv('TELEGRAM_BOT_TOKEN');
$telegram = new Api($token);

$result = $telegram->getWebhookUpdates();

$intents = [];
$intents[] = new \App\intents\StartIntent($telegram, $result);
$intents[] = new \App\intents\UnknownIntent($telegram, $result);
/** @var \App\intents\BaseIntent $intent */
foreach ($intents as $intent) {
    if ($intent->isApplied()) {
        return $intent->execute();
    }
}
