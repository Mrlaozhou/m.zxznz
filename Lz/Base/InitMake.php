<?php 

$config = require_once('/Config/configs.php');

$dir = scandir(ROOT_PATH);


function InitMakeDir($c)
{
	$filename = ROOT_PATH.'Html'.DS.trim($c);
	if( !file_exists($filename) )
		mkdir($filename, 0777, true);
}
$need = array_diff($config['DIR'],$dir);

if( !empty($need) )
	array_map('InitMakeDir',$need);
