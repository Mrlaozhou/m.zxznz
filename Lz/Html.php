<?php 



//定义路劲常量
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
// defined('ROOT_PATH') or define('ROOT_PATH',getcwd().DS);
defined('ROOT_PATH') or define('ROOT_PATH','.'.DS);
defined('HTML_PATH') or define('HTML_PATH',ROOT_PATH.'Html'.DS);
defined('SRC_PATH') or define('SRC_PATH',HTML_PATH.'src'.DS);
defined('VIEW_PATH') or define('VIEW_PATH',HTML_PATH.'view'.DS);

//定义路由常量
defined('CONTROLLER') or define('CONTROLLER',isset($_GET['c']) ? ucwords(trim($_GET['c'])) : null);
defined('ACTION') or define('ACTION',isset($_GET['a']) ? trim($_GET['a']) : 'index');

//加载函数文件
find('./Config/functions.php');


if( CREATE )
	require_once('./Lz/Base/InitMake.php');
if( CONTROLLER )
	find(SRC_PATH.CONTROLLER.'.php');
if( ACTION )
{
	$views = scandir(VIEW_PATH);
	array_shift($views);
	array_shift($views);
	$a = ACTION.'.html';
	if( !in_array($a,$views) )
		//页面错误拦截
		find(VIEW_PATH.'404.html');
	find(VIEW_PATH.ACTION.'.html');
}


function find($path)
{
	if( file_exists($path) )
		require_once($path);
	return ;
}