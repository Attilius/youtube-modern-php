<?php

require './functions.php';

//$dayOfYear = date('z') + 1;   // TODO amint van minden napra kérdés ezt cseréljük vissza
$dayOfYear = 213;
$data = json_decode(file_get_contents('./' . $dayOfYear . '.json'));


// a $data->answers-t tömbbé alakítjuk
$answers = (array) $data->answers;
$data = (array) $data;
$data['answers'] = $answers;
$totalVotes = array_sum($data['answers']);

// jött-e új option
if ($_POST['new-option']) {
    $data['answers'][$_POST['new-option']] = 1;
    saveVotes($dayOfYear, $data);
}

if ($_POST['vote']) {
    if (in_array($_POST['vote'], array_keys($data['answers']))) {
        // növeljük a kiválasztott választ 1-gyel
        $data['answers'][$_POST['vote']]++;
        saveVotes($dayOfYear, $data);
    }
    // TODO ha olyanra szavazott ami nem létezik akkor loggoljuk a választ és az IP címet és a timestampet
}

require './template.php';
