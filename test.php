<?php

include('vendor/autoload.php');


$generator = new \App\model\game\MazeGenerator();
$grid = $generator->createMaze(1, 1, 10, 10, null);
//var_dump($grid);

echo '<pre>';
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
    echo '<br>';
}
echo '</pre>';
