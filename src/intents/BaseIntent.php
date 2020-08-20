<?php

namespace App\intents;

use Telegram\Bot\Api;

abstract class BaseIntent
{
    protected $message;
    /** @var Api */
    protected $telegram;

    public function __construct($message, $telegram)
    {
        $this->message = $message;
        $this->telegram = $telegram;
    }

    /**
     * Метод дает ответ пользователю на его сообщение(намерение)
     * @return void
     */
    abstract public function execute();

    /**
     * проверяем принадлежит ли сообщение к текущему намерению
     * @return bool
     */
    abstract public function isApplied();
}