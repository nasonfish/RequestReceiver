<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=\"DarkHelmet Minecraft MODREQ stats ajax\"");
    header("HTTP/1.0 401 Unauthorized");
    echo '401 Unauthorized - No username/password supplied. Sorry.';
    exit;
} else {
    if(strtoupper($_SERVER['PHP_AUTH_USER']) != "DHMC_STAFF" || $_SERVER['PHP_AUTH_PW'] != file_get_contents('authpass.txt')){
        header("WWW-Authenticate: Basic realm=\"DarkHelmet Minecraft MODREQ stats ajax\"");
        header("HTTP/1.0 401 Unauthorized");
        echo "401 Unauthorized - Incorrect username/password. Sorry.";
        exit;
    }
}

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
        print_request_ids(requestsByUser_ids($peregrine->post->isDate('date') ? $peregrine->post->getDate('date') : date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60)), $peregrine->post->getRaw('name')), false);
    }
} elseif($peregrine->post->equals('type', 'mod')){
    if($peregrine->post->isSetAndNotEmpty('name')){
        print_request_ids(requestsByMod_ids($peregrine->post->isDate('date') ? $peregrine->post->getDate('date') : date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60)), $peregrine->post->getRaw('name')), true);
    }
} elseif($peregrine->post->equals('type', 'id')){
    if($peregrine->post->isSetAndNotEmpty('id')){
        print_request_single(requestById($peregrine->post->getInt('id')));
    }
} else {
    exit;
}