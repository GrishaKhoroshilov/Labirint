<?php


namespace App\model\game;


use App\utils\App;

class Maze
{
    public $grid;

    /**
     * Maze constructor.
     */
    public function __construct()
    {
    }

    public function generate()
    {
        $generator = new \App\model\game\MazeGenerator();
        $this->grid = $generator->createMaze(1, 1, 14, 50, null);
        return $this->save();
    }

    public function load($id)
    {
        $maze = App::app()->db->select('SELECT * FROM maze WHERE id = :id', [
            ':id' => $id
        ]);
        $this->grid = unserialize($maze['maze']);
    }

    public function save()
    {
       return App::app()->db->insert('maze', [
           'maze' => serialize($this->grid),
           'created' => date('Y-m-d H:i:s')
       ]);
    }
}