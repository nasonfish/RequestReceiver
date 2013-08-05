<?php
include 'Util.php';
$text = sprintf("Request claimed: #%s, claimed by %s", $_POST['id'], $_POST['modname']);
irc_send($text);