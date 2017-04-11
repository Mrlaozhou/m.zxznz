<?php
// +----------------------------------------------------------------------
// |  	入口文件
// +----------------------------------------------------------------------
// | 	Date: 2017-03-04
// +----------------------------------------------------------------------
header("Content-Type:text/html;Charset=utf-8");

//开启 session
@session_start();


/*home*///是否自动创建
define('CREATE',TRUE);

// 网站根目录
define('__ROOT__',__DIR__);


/*admin*///
defined('DB_NAME') or define('DB_NAME','zxznz');
defined('DB_ROOT') or define('DB_ROOT','root');
defined('DB_PASS') or define('DB_PASS','laozhou');
defined('ALLOW_HOST') or define('ALLOW_HOST','*');

//print_r($_SERVER['PATH_INFO']);


/*判断是页面请求 还是api请求*/



if( !isset($_SERVER['PATH_INFO']) )
	require_once('/Lz/Html.php');
else
	require_once("Lz/lz.php");

