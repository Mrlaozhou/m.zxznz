<?php 

// +----------------------------------------------------------------------
// |  	接口入口文件
// +----------------------------------------------------------------------
// | 	Date: 2017-03-13
// +----------------------------------------------------------------------
header("Content-Type:text/html;Charset=utf-8");

defined('DB_NAME') or define('DB_NAME','zxznz');
defined('DB_ROOT') or define('DB_ROOT','root');
defined('DB_PASS') or define('DB_PASS','laozhou');
defined('ALLOW_HOST') or define('ALLOW_HOST','*');

@session_start();
// 网站根目录
define('__ROOT__',__DIR__);
require_once(__ROOT__."/Lz/Lz.php");