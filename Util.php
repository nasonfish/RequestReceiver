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
    getDB()->query(sprintf('INSERT INTO requests (request_id, username, modname, text) VALUES (\'%s\', \'%s\', \'%s\', \'%s\');', $request, $username, $modname, $text));
   // print(sprintf('INSERT INTO requests (request_id, username, modname, text) VALUES (\'%s\', \'%s\', \'%s\', \'%s\')', $request, $username, $modname, $text));
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
    $query = sprintf('SELECT SUM(1) as amt, modname FROM requests WHERE timestamp > Datetime( \'%s\' ) GROUP BY modname ORDER BY amt DESC', $ts);
    $res = $db->query($query);
    return makeArray($res);
}

function requestsByUser_amt($ts){
    $db = getDB();
    $query = sprintf('SELECT SUM(1) as amt, username FROM requests WHERE timestamp > Datetime( \'%s\') GROUP BY username ORDER BY amt DESC', $ts);
    $res = $db->query($query);
    return makeArray($res);
}

function requestsByMod_ids($ts, $mod){
    $db = getDB();
    $mod = preg_replace('/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_]/', '', $mod);
    $query = sprintf('SELECT rowid FROM requests WHERE timestamp > Datetime(\'%s\') AND modname = \'%s\'', $ts, $mod);
    $res = $db->query($query);
    return makeArray($res);
}

function requestsByUser_ids($ts, $user){
    $db = getDB();
    $user = preg_replace('/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_]/', '', $user);
    $query = sprintf('SELECT rowid FROM requests WHERE timestamp > Datetime(\'%s\') AND username = \'%s\'', $ts, $user);
    $res = $db->query($query);
    return makeArray($res);
}

function requestById($id){
    $db = getDB();
    $res = $db->query(sprintf('SELECT * from requests WHERE rowid = %s;', $id));
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
    return($result->fetchArray(SQLITE3_ASSOC));
}


////////////////////////////////
////// PRINTING FUNCTIONS //////
////////////////////////////////

function print_user_requests($array){
    print '<ul>';
    foreach($array as $row){
        print sprintf('<li class="user user_li"><a><span class="user_name">%s</span></a> &rarr; <span class="user_amount">%s</span></li>', $row['username'], $row['amt']);
    }
    print '</ul>';
}

function print_mod_requests($array){
    print '<ul>';
    foreach($array as $row){
        print sprintf('<li class="mod mod_li"><a><span class="mod_name">%s</span></a> &rarr; <span class="mod_amount">%s</span></li>', $row['modname'], $row['amt']);
    }
    print '</ul>';
}

function print_request_ids($array){
    print '<ul>';
    foreach($array as $row){
        print sprintf('<li class="req_id id_li"><a><span class="id">%s</span></a></li>', $row['rowid']);
    }
    print '</ul>';
}

function print_request_single($array){
    print '<ul class="req_stats">';
    foreach($array as $key => $val){
        print sprintf('<li><span class="key">%s</span> &rarr; <span class="val">%s</span></li>', $key, $val);
    }
    print '</ul>';
}