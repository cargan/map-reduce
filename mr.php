<?php
$lines = array(
             'one two three four',
             'two three four',
             'three four',
             'four one one',
             );

$lineToWordCounts = function($line) {
    return array_count_values(explode(' ', $line));
};


$counts = array_map($lineToWordCounts, $lines);

$sumWordCounts =
    function($countsL, $countsR) {
        // Get all the words
        $words = array_merge(array_keys($countsL), array_keys($countsR));
        $out = array();
        // Put them in a new (Array: Word => Count)
        foreach($words as $word) {
            // Sum their counts
            $out[$word] = isset($countsL[$word]) ? $countsL[$word] : 0;
            $out[$word] += isset($countsR[$word]) ? $countsR[$word] : 0;
        }
        return $out;
    };

$totals = array_reduce($counts, $sumWordCounts, array());
print_r($counts);
var_export($totals);

