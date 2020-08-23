<?php

namespace App\model\game;

interface IGame
{
    public function start($difficulty);
    public function save();
    public function finish();
    public function quit();
    public function move($direction);

    public function getGameField();
    // на будущее многопользовательская join in game
}