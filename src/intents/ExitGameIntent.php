<?php

namespace App\intents;

use App\enums\GameMenuEnum;
use App\model\game\SingleGame;
use App\model\game\User;

class ExitGameIntent extends BaseIntent
{

    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    public function execute()
    {
        $user = new User($this->message["message"]["chat"]["id"]);
        // TODO: DI ???
        $game = new SingleGame($user);
        $game->quit();
        $this->telegram->sendMessage([
            'chat_id' => $this->message['message']["chat"]["id"],
            'text' => 'Вы успешно вышли из игры!'
        ]);
    }

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    public function isApplied()
    {
        return $this->message["message"]["text"] == GameMenuEnum::EXIT_GAME;
    }
}