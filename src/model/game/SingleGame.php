<?php


namespace App\model\game;


use App\enums\DifficultyEnum;
use App\utils\App;

class SingleGame implements IGame
{
    /** @var Maze */
    protected $maze;
    protected $id;
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
        $mazeId = $this->maze->generate();

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
        // TODO: Implement move() method.
    }

    public function getGameField()
    {

        $viewSize = 3;
        $game = App::app()->db->select('SELECT * FROM game WHERE user_id = :user_id AND status = \'active\'', [
            ':user_id' => $this->user->id
        ]);
        $size = $this->geSizeByDifficulty($game['difficulty']);
        $minY = max(1, $game['y'] - $viewSize);
        $maxY = min($size['height'], $game['y'] + $viewSize);
        $minX = max(1, $game['x'] - $viewSize);
        $maxX = min($size['width'], $game['x'] + $viewSize);

        $result = '';
        for ($y = $minY; $y <= $maxY; $y++ ) {
            // $result .= '|';
            for ($x = $minX; $x <= $maxX; $x++) {
                $cell = $this->maze->grid[$y][$x];
                if ($cell['bottom_wall']) {
                    $result .= '_';
                } else {
                    $result .= ' ';
                }

                if ($cell['right_wall']) {
                    $result .= '|';
                } else {
                    $result .= ' ';
                }
            }
            $result .= PHP_EOL;
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
}