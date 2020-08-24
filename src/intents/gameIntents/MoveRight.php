<?php


namespace App\intents\gameIntents;


use App\enums\GameEventEnum;


class MoveRight extends BaseGameIntent
{
    protected $maze;
    protected $player;

    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    public function isApplied()
    {
        return $this->message["message"]["text"] == GameEventEnum::MOVE_RIGHT;
    }
}