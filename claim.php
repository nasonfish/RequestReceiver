<?php
if($_SERVER['REMOTE_ADDR'] != "69.162.95.26" && $_SERVER['REMOTE_ADDR'] != "71.196.170.51"){exit;}
include 'Util.php';
$text = sprintf("Request claimed: #%s, claimed by %s", $_POST['id'], $_POST['modname']);
irc_send($text);