<?php

namespace App\intents\gameIntents;

use App\intents\BaseIntent;

abstract class BaseGameIntent extends BaseIntent
{
    protected $maze;
    protected $player;

    public function __construct($telegram, $message, $maze, $player)
    {
        $this->maze = $maze;
        $this->player = $player;
        parent::__construct($telegram, $message);
    }


}