<?php 
header("Content-Type:text/html;charset=utf-8");



defined('ROOT') or define('ROOT','/');
defined('TEST') or define('TEST',ROOT.'TEST/');


defined('MODULE') or define('MODULE','test1');

defined('INDEX') or define('INDEX',TEST.MODULE.'/');

// echo '<pre>';
// print_r($_SERVER);
// exit;

$URL = 'http://'.$_SERVER['HTTP_HOST'].INDEX;
header("Location:{$URL}");