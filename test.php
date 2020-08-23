<?php

include('vendor/autoload.php');

try {
    \App\utils\App::app()->db->select('select * from users');
} catch (Throwable $exception) {
    var_dump($exception->getMessage());
}

/*

$generator = new \App\model\game\MazeGenerator();
$grid = $generator->createMaze(1, 1, 14, 50, null);
//var_dump($grid);

foreach ($grid as $y => $row) {
    echo '|';
    foreach ($row as $x => $cell) {
        if ($cell['bottom_wall']) {
            echo '_';
        } else {
            echo ' ';
        }

        if ($cell['right_wall']) {
            echo '|';
        } else {
            echo ' ';
        }

    }
    echo PHP_EOL;
}
*/
