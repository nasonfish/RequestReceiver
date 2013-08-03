<?php
if($_SERVER['REMOTE_ADDR'] != "69.162.95.26" && $_SERVER['REMOTE_ADDR'] != "71.196.170.51"){exit;}
$text = sprintf("Request submitted: #%s, by %s: %s", $_POST['id'], $_POST['username'], $_POST['text']);

include 'Util.php';
irc_send($text);
