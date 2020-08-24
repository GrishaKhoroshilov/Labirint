<?php


namespace App\model\game;


use App\enums\DifficultyEnum;
use App\enums\GameEventEnum;
use App\utils\App;

class SingleGame implements IGame
{
    /** @var Maze */
    protected $maze;
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function start($difficulty)
    {
        $game = App::app()->db->select('SELECT * FROM game WHERE user_id = :user_id AND status = \'active\'', [
            ':user_id' => $this->user->id
        ]);
        if ($game) {
            return 'Нельзя создать более 1 игры';
        }
        $size = $this->geSizeByDifficulty($difficulty);
        $this->maze = new Maze();
        $mazeId = $this->maze->generate($size);

        App::app()->db->insert('game', [
            'maze_id' => $mazeId,
            'user_id' => $this->user->id,
            'created' => date('Y-m-d H:i:s'),
            'difficulty' => $difficulty,
            'x' => 1,
            'y' => 1,
            'exit_x' => $size['width'],
            'exit_y' => $size['height'],
            'status' => 'active' // TODO сделать енумы!!!!!!!!!
        ]);
    }

    public function save()
    {

    }

    public function finish()
    {
        // TODO: Implement finish() method.
    }

    public function move($direction)
    {
        $game = App::app()->db->select('SELECT * FROM game WHERE user_id = :user_id AND status = \'active\'', [
            ':user_id' => $this->user->id
        ]);
        $maze = new Maze();
        $maze->load($game['maze_id']);
        $size = $this->geSizeByDifficulty($game['difficulty']);
        $grid = $maze->grid;
        // перемешение налево
        if ($direction == GameEventEnum::MOVE_LEFT) {
            $x = $game['x'] - 1;
            if ($x < 1) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            $checkCell = $grid[$game['y']][$x];
            if ($checkCell['right_wall']) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            App::app()->db->update('UPDATE game SET x = :x WHERE id = :id', [
                ':id' => $game['id'],
                ':x' => $x
            ]);
            return GameEventEnum::SUCCESS_MOVE;
        }
        // перемещение направо
        if ($direction == GameEventEnum::MOVE_RIGHT) {
            $x = $game['x'];
            if ($x > $size['width']) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            $checkCell = $grid[$game['y']][$x];
            if ($checkCell['right_wall']) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            $game['x'] = $game['x'] + 1;
            App::app()->db->update('UPDATE game SET x = :x WHERE id = :id', [
                ':id' => $game['id'],
                ':x' => $game['x']
            ]);
            return GameEventEnum::SUCCESS_MOVE;
        }
        // перемешение вверх
        if ($direction == GameEventEnum::MOVE_UP) {
            $x = $game['x'];
            $y = $game['y'] - 1;

            if ($y < 1) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            $checkCell = $grid[$y][$x];
            if ($checkCell['bottom_wall']) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            App::app()->db->update('UPDATE game SET y = :y WHERE id = :id', [
                ':id' => $game['id'],
                ':y' => $y
            ]);
            return GameEventEnum::SUCCESS_MOVE;
        }
        // перемешение вниз
        if ($direction == GameEventEnum::MOVE_DOWN) {
            $x = $game['x'];
            $y = $game['y'];
            if ($y + 1 > $size['height']) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            $checkCell = $grid[$y][$x];
            if ($checkCell['bottom_wall']) {
                return GameEventEnum::UN_SUCCESS_MOVE;
            }
            $game['y'] = $y + 1;
            App::app()->db->update('UPDATE game SET y = :y WHERE id = :id', [
                ':id' => $game['id'],
                ':y' => $game['y']
            ]);
            return GameEventEnum::SUCCESS_MOVE;
        }
    }

    public function getGameField()
    {
        $viewSize = 5;
        $game = App::app()->db->select('SELECT * FROM game WHERE user_id = :user_id AND status = \'active\'', [
            ':user_id' => $this->user->id
        ]);
        $size = $this->geSizeByDifficulty($game['difficulty']);
        $minY = max(1, $game['y'] - $viewSize);
        $maxY = min($size['height'], $game['y'] + $viewSize);
        $minX = max(1, $game['x'] - $viewSize);
        $maxX = min($size['width'], $game['x'] + $viewSize);

        $result = '';

        for ($x = $minX; $x <= $maxX; $x++) {
            if ($minY == 1) {
                $result .= '__';
            } else {
                $result .= '..';
            }

        }
        $result .= PHP_EOL;

        for ($y = $minY; $y <= $maxY; $y++ ) {
            if ($minX == 1) {
                $result .= '|';
            } else {
                $result .= '.';
            }

            for ($x = $minX; $x <= $maxX; $x++) {
                $cell = $this->maze->grid[$y][$x];
                if ($cell['bottom_wall'] && $x == $game['x'] && $y == $game['y']) {
                    $result .= '<u>*</u>';
                } elseif ($cell['bottom_wall']) {
                    $result .= '_';
                } elseif ($x == $game['x'] && $y == $game['y']) {
                    $result .= '*';
                } else {
                    $result .= ' ';
                }

                if ($cell['right_wall']) {
                    $result .= '|';
                } else {
                    $result .= ' ';
                }
            }

            if ($maxX == $size['width']) {
                $result .= '|';
            } else {
                $result .= '.';
            }

            $result .= PHP_EOL;
        }

        for ($x = $minX; $x <= $maxX; $x++) {
            if ($maxY == $size['height']) {
                $result .= '__';
            } else {
                $result .= '..';
            }

        }

        return $result;
    }

    private function geSizeByDifficulty($difficulty)
    {
        if ($difficulty == DifficultyEnum::EASY) {
            return [
                'width' => 10,
                'height' => 10
            ];
        } else {
            return [
                'width' => 10,
                'height' => 10
            ];
        }

    }

    public function quit()
    {
        $game = App::app()->db->select('SELECT * FROM game WHERE user_id = :user_id AND status = \'active\'', [
            ':user_id' => $this->user->id
        ]);

        App::app()->db->update('UPDATE game SET status = \'deleted\' WHERE id = :id', [
            ':id' => $game['id']
        ]);
    }
}