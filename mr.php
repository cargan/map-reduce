<?php

$lines = array(
             'one two three four',
             'two three four',
             'three four',
             'four one one',
             );

$lineToWordCounts =
    function($line) {
        return array_count_values(explode(' ', $line));
    };


$counts = array_map($lineToWordCounts, $lines);

print_r($counts);
