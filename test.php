<?php

include('vendor/autoload.php');

$maze = new \App\model\game\Maze();

$maze->load($_GET['id']);


foreach ($maze->grid as $y => $row) {
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
