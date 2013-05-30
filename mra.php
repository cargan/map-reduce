<?php
$data = './data/*';

$lineToData = function($line) {
    $it  = explode(':::', $line);
    $item['id'] = $it[0];
    $item['title'] = trim($it[2]);
    $item['authors'] = explode('::', $it[1]);

    return $item;
};

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


$sumDataCounts =
    function($countsL, $countsR) {
        if (!in_array($auth, $countsR['authors'])) {
            return $countsL;
        }

        foreach ($countsR['authors'] as $author) {
            if ($author != $auth) {
                continue;
            }
            $title = explode(' ', trim($countsR['title'], ";:,?!."));
            if (isset($countsL[$author])) {
                // $countsL[$author]['items'][] = array(
                //     'id' => $countsR['id'],
                //     'title' => $countsR['title']
                // );
                $countsL[$author]['titles'] = array_count_values($title);
            } else {
                // $countsL[$author] = array('items'=>array(), 'titles' => array());
                // $countsL[$author]['items'][] = array(
                //     'id' => $countsR['id'],
                //     'title' => $countsR['title'],
                // );
                $countsL[$author]['titles'] = array_count_values($title);
            }

        }

        return $countsL;
    };

$totals = array();
$totalsFirst = array('Michael Brady' => array());

foreach (glob($data) as $file) {
    $dataStream = explode("\n", trim(file_get_contents($file)));
    $dataConverted = array_map($lineToData, $dataStream);
    // print_r($dataConverted);exit;
    $totalsFirst = array_reduce($dataConverted, function($reduced, $current) {
        foreach ($reduced as $author=>$data) {
            if (in_array($author, $current['authors'])) {
                $reduced[$author][] = $current['title'];
            }
        }
        return $reduced;
    }, $totalsFirst);
}

print_r($totalsFirst);

