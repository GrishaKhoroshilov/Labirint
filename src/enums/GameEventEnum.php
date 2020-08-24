<?php


namespace App\enums;


class GameEventEnum
{
    const SUCCESS_MOVE = 1;
    const UN_SUCCESS_MOVE = 2;
    const TIMEOUT = 3;
    const FINISH_GAME = 4;
    const MOVE_LEFT = 'влево';
    const MOVE_RIGHT = 'вправо';
    const MOVE_UP = 'вверх';
    const MOVE_DOWN = 'вниз';

}