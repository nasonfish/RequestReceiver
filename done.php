<?php
if($_SERVER['REMOTE_ADDR'] != "69.162.95.26" && $_SERVER['REMOTE_ADDR'] != "71.196.170.51"){exit;}
include('Util.php');
include('peregrine/Peregrine.php');
$peregrine = new Peregrine();
$peregrine->init();
// debug
//$peregrine->post = $peregrine->get;
//var_dump($peregrine->post->getRawSource());
if(
    $peregrine->post->keyExists('message')
    && $peregrine->post->isUsername('name')
    && ($peregrine->post->isUsername('modname') || $peregrine->post->isUsername('triggerer'))
    && $peregrine->post->keyExists('id'))
{
    if($peregrine->post->equals('modname', 'null')){
        irc_send(sprintf("Request completed: #%s, completed by %s", $peregrine->post->getInt('id'), $peregrine->post->getUsername('triggerer')));
    }
    save_request(
        $peregrine->post->getInt('id'),
        $peregrine->post->getUsername('name'),
        ($peregrine->post->equals('modname', 'null') ? $peregrine->post->getUsername('triggerer') : $peregrine->post->getUsername('modname')),
        $peregrine->post->getRaw('message')
    );
}