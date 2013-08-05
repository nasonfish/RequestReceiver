<?php

include 'peregrine/Peregrine.php';

$peregrine = new Peregrine;
$peregrine->init();

// DEBUG
//$peregrine->post = $peregrine->get;

if(!$peregrine->post->isInArray('type', array('user', 'mod', 'id'))){
    exit;
}

include 'Util.php';

if($peregrine->post->equals('type', 'user')){
    if($peregrine->post->isSetAndNotEmpty('name')){
        print_request_ids(requestsByUser_ids($peregrine->post->isDate('date') ? $peregrine->post->getDate('date') : date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60)), $peregrine->post->getRaw('name')));
    }
} elseif($peregrine->post->equals('type', 'mod')){
    if($peregrine->post->isSetAndNotEmpty('name')){
        print_request_ids(requestsByMod_ids($peregrine->post->isDate('date') ? $peregrine->post->getDate('date') : date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60)), $peregrine->post->getRaw('name')));
    }
} elseif($peregrine->post->equals('type', 'id')){
    if($peregrine->post->isSetAndNotEmpty('id')){
        print_request_single(requestById($peregrine->post->getInt('id')));
    }
} else {
    exit;
}