<?php
$data = './data/*';

$lineToData = function($line) {
    $it  = explode(':::', $line);
    $item['id'] = $it[0];
    $item['title'] = trim($it[2]);
    $item['authors'] = explode('::', $it[1]);

    return $item;
};

$sumDataCounts =
    function($countsL, $countsR) {
        // var_dump($countsL);
        // var_dump($countsR);

        // exit;
        foreach ($countsR['authors'] as $author) {
            if (isset($countsL[$author])) {
                $countsL[$author]['items'][] = array(
                    'id' => $countsR['id'],
                    'title' => $countsR['title']
                );
            } else {
                $countsL[$author] = array('items'=>array());
                $countsL[$author]['items'][] = array(
                    'id' => $countsR['id'],
                    'title' => $countsR['title']
                );
            }

        }

        return $countsL;
    };

$totals = array();
foreach (glob($data) as $file) {
    var_dump($file);
    $dataStream = explode("\n", trim(file_get_contents($file)));
    $dataConverted = array_map($lineToData, $dataStream);
    $totals = array_reduce($dataConverted, $sumDataCounts, $totals);
}


print_r($totals);

