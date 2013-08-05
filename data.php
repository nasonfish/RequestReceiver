<?php

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=\"DarkHelmet Minecraft MODREQ stats\"");
    header("HTTP/1.0 401 Unauthorized");
    echo '401 Unauthorized - No username/password supplied. Sorry.';
    exit;
} else {
    if(strtoupper($_SERVER['PHP_AUTH_USER']) != "DHMC_STAFF" || $_SERVER['PHP_AUTH_PW'] != file_get_contents('authpass.txt')){
        header("WWW-Authenticate: Basic realm=\"DarkHelmet Minecraft MODREQ stats\"");
        header("HTTP/1.0 401 Unauthorized");
        echo "401 Unauthorized - Incorrect username/password. Sorry.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>DHMC Modreq stats</title>
    <?php include('Util.php'); ?>
    <link rel="stylesheet" href="data.css" type="text/css"/>
</head>
    <body>
        <div class="mods_box">
            <h2>Mods</h2>
            <?php print_mod_requests(requestsByMod_amt((date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60))))); ?>
        </div>
        <div class="users_box">
            <h2>Users</h2>
            <?php print_user_requests(requestsByUser_amt(date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60))));?>
        </div>
    </body>

<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="data.js"></script>
</html>