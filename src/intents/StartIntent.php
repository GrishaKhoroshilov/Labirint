<?php


namespace App\intents;


use App\enums\GameMenuEnum;
use App\enums\GameTypeEnum;
use Telegram\Bot\Api;

class StartIntent extends BaseIntent
{

    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    public function execute()
    {
        $keyboard = [
            [GameTypeEnum::SINGLE_GAME], ["поле2"], [GameMenuEnum::EXIT_GAME]
        ];
        $keyboardMarkup = [
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];
        $keyboardMarkup = json_encode($keyboardMarkup);
        $this->telegram->sendMessage([
            'chat_id' => $this->message['message']["chat"]["id"],
            'text' => 'Добро пожаловать в Лабиринт!
- Здесь вы можете поиграть в лабиринт головоломку со своим другом.
- Один из вас будет направлять другого 
- Попробуй найти выход',
            'reply_markup' => $keyboardMarkup
        ]);

    }

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    public function isApplied()
    {
        return $this->message["message"]["text"] == '/start';
    }
}