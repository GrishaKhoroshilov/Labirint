<?php


namespace App\intents\gameIntents;


use App\enums\GameEventEnum;
use App\model\game\SingleGame;
use App\model\game\User;

class MoveLeft extends BaseGameIntent
{

    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    public function execute()
    {
        $user = new User($this->message["message"]["chat"]["id"]);
        $game = new SingleGame($user);
        $game->move(GameEventEnum::MOVE_LEFT);
        $this->telegram->sendMessage([
            'chat_id' => $this->message['message']["chat"]["id"],
            'text' => GameEventEnum::SUCCESS_MOVE
        ]);
    }

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    public function isApplied()
    {
        return $this->message["message"]["text"] == GameEventEnum::MOVE_LEFT;
    }
}