<?php
////////////////////
////// FIELDS //////
////////////////////

$db = false;

/////////////////////////////////////////////////////
////// FUNCTIONS THE MINECRAFT SERVER TRIGGERS //////
/////////////////////////////////////////////////////


function irc_send($text = false){
    $pass = file_get_contents('pass.txt');
    exec("echo 'NICK Refract
USER Refract
PASS $pass
PRIVMSG #Refract :$text
QUIT :Farewell!' | /home/sites/netcat nasonfish.com 8080");
}

function save_request($request, $username, $modname, $text){
    $db = getDB();
    $stmnt = $db->prepare('INSERT INTO requests (request_id, username, modname, text) VALUES (:request,:username,:modname,:text)');
    $stmnt->bindValue(':request', $request);
    $stmnt->bindValue(':username', $username);
    $stmnt->bindValue(':modname', $modname);
    $stmnt->bindValue(':text', $text);
    $stmnt->execute();
    $stmnt->close();
}

/////////////////////////////////
////// LOCAL PRIVATE STUFF //////
/////////////////////////////////

function getDB(){
    global $db;
    if(!$db){
        $db = new SQLite3('/home/sites/stufflibs/req/Requests.db');
    }
    return $db;
}

//////////////////////////////////////////////
////// QUERY-EXECUTING STUFF, FOR STATS //////
//////////////////////////////////////////////

function requestsByMod_amt($ts){
    $db = getDB();
    $stmnt = $db->prepare('SELECT SUM(1), modname FROM requests WHERE timestamp > :ts GROUP BY modname;');
    $stmnt->bindValue(':ts', $ts);
    $res = $stmnt->execute();
    $stmnt->close();
    return makeArray($res);
}

function requestsByUser_amt($ts){
    $db = getDB();
    $stmnt = $db->prepare('SELECT SUM(1), username FROM requests WHERE timestamp > :ts GROUP BY username;');
    $stmnt->bindValue(':ts', $ts);
    $res = $stmnt->execute();
    $stmnt->close();
    return makeArray($res);
}

function requestsByMod_ids($ts, $mod){
    $db = getDB();
    $stmnt = $db->prepare('SELECT id FROM requests WHERE timestamp > :ts AND modname = :mod;');
    $stmnt->bindValue(':ts', $ts);
    $stmnt->bindValue(':mod', $mod);
    $res = $stmnt->execute();
    $stmnt->close();
    return makeArray($res);
}

function requestsByUser_ids($ts, $user){
    $db = getDB();
    $stmnt = $db->prepare('SELECT id FROM requests WHERE timestamp > :ts AND username = :user;');
    $stmnt->bindValue(':ts', $ts);
    $stmnt->bindValue(':user', $user);
    $res = $stmnt->execute();
    $stmnt->close();
    return makeArray($res);
}

function requestById($id){
    $db = getDB();
    $stmnt = $db->prepare('SELECT * from requests WHERE id = :id;');
    $stmnt->bindValue(':id', $id);
    $res = $stmnt->execute();
    $stmnt->close();
    return makeArraySingle($res);
}

////////////////////////////////
////// ARRAY-MAKING STUFF //////
////////////////////////////////

function makeArray($result){
    $arr = array();
    $i = 0;
    while($res = $result->fetchArray(SQLITE3_ASSOC)){
        $arr[$i] = $res;
        $i++;
    }
    return $arr;
}

function makeArraySingle($result){
    // I think I can just...
    return $result->fetchArray();
}


////////////////////////////////
////// PRINTING FUNCTIONS //////
////////////////////////////////
function print_requests($array){

}

function print_request_single($array){

}