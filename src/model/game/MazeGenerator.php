<?php


namespace App\model\game;


class MazeGenerator
{
    protected $aux;

    public function __construct()
    {
        $this->aux = (object)[
            'width' => false,
            'height' => false,
            'sx' => false,
            'sy' => false,
            'grid' => false
        ];
    }

    private function createGrid($rows, $columns)
    {
        $mazeGrid = [];
        for ($y = 1; $y <= $rows; $y++) {
            $mazeGrid[$y] = [];
            for ($x = 1; $x <= $columns; $x++) {
                $mazeGrid[$y][$x] = [
                    'bottom_wall' => true, 'right_wall' => true
                ];
            }
        }

        return $mazeGrid;
    }

    public function createMaze($x1, $y1, $x2, $y2, $grid)
    {
        $this->aux->height = $y2;
        $this->aux->width = $x2;
        $this->aux->sx = $x1;
        $this->aux->sy = $y1;
        $this->aux->grid = $grid ? $grid : $this->createGrid($y2, $x2);
        $this->sidewinder();

        return $this->aux->grid;
    }

    private function sidewinder()
    {
        $cx = $this->aux->sx;
        for ($y = $this->aux->sy; $y <= $this->aux->height; $y++) {
            for ($x = $this->aux->sx; $x <= $this->aux->width; $x++) {
                if ($y != $this->aux->sy) {
                    if (rand(0, 1) == 0 && $x != $this->aux->width) {
                        $this->aux->grid[$y][$x]['right_wall'] = false;
                    } else {
                        $this->aux->grid[$y-1][rand($cx, $x)]['bottom_wall'] = false;

                        if ($x != $this->aux->width) {
                            $cx = $x + 1;
                        } else {
                            $cx = $this->aux->sx;
                        }
                    }
                } else {
                    if ($x != $this->aux->width) {
                        $this->aux->grid[$y][$x]['right_wall'] = false;
                    }
                }
            }
        }
    }

}