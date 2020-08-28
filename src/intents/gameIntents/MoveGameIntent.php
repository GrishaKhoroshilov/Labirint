<?php


namespace App\intents\gameIntents;


use App\enums\GameEventEnum;
use App\model\game\SingleGame;
use App\model\game\User;

class MoveGameIntent extends BaseGameIntent
{

    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    public function execute()
    {
        $user = new User($this->message["message"]["chat"]["id"]);
        $game = new SingleGame($user);
        $result = $game->move($this->message["message"]["text"]);
        if ($result == GameEventEnum::UN_SUCCESS_MOVE) {
            $this->sendMessage([
                'text' => 'Тупик'
            ]);
            return;
        }
        $text = $game->getGameField();
        $this->sendMessage([
            'text' => '<pre>' . $text . '</pre>',
            'parse_mode' => 'HTML'
        ]);
        if ($game->finish()) {
            $this->sendMessage([
                'text' => 'Вы нашли выход'
            ]);
        }
    }

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    public function isApplied()
    {
        return in_array($this->message["message"]["text"], [
            GameEventEnum::MOVE_LEFT,
            GameEventEnum::MOVE_RIGHT,
            GameEventEnum::MOVE_UP,
            GameEventEnum::MOVE_DOWN,
        ]);
    }
}