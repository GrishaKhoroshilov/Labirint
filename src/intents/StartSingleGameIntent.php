<?php


namespace App\intents;


use App\enums\GameEventEnum;
use App\enums\GameTypeEnum;
use App\model\game\SingleGame;
use App\model\game\User;

class StartSingleGameIntent extends BaseIntent
{


    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    public function execute()
    {
        $user = new User($this->message["message"]["chat"]["id"]);
        $game = new SingleGame($user);
        $res = $game->start('normal');
        if (is_string($res)) {
            $this->telegram->sendMessage([
                'chat_id' => $this->message['message']["chat"]["id"],
                'text' => $res
            ]);
            return;
        }
        $text = $game->getGameField();
        $keyboard = [
            [GameTypeEnum::SINGLE_GAME], [GameEventEnum::MOVE_UP], [GameEventEnum::MOVE_DOWN], [GameEventEnum::MOVE_LEFT], [GameEventEnum::MOVE_RIGHT]
        ];
        $keyboardMarkup = [
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ];
        $keyboardMarkup = json_encode($keyboardMarkup);
        $this->telegram->sendMessage([
            'chat_id' => $this->message['message']["chat"]["id"],
            'text' => '<pre>' . $text . '</pre>',
            'reply_markup' => $keyboardMarkup,
            'parse_mode' => 'HTML'
        ]);
    }

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    public function isApplied()
    {
        return $this->message["message"]["text"] == GameTypeEnum::SINGLE_GAME;
    }
}