<?php
// +----------------------------------------------------------------------
// |  	公共入口文件 ：路由解析、参数分发
// +----------------------------------------------------------------------
// | 	Date: 2017-03-04
// +----------------------------------------------------------------------


/************路由解析************/
//解析参数

$config = require_once('/Lz/url.php');

//处理参数 去空格
$config = @array_map('trim',$config) or exit('路由错误！');

defined('__MODULE__') or define('__MODULE__',ucwords($config['m']));
defined('__ACTION__') or define('__ACTION__',isset($config['a']) ? $config['a'] : 'index');

/************定义路径常量************/
defined("EXT") or define("EXT",".php");
defined("DS") or define("DS",DIRECTORY_SEPARATOR);
defined("ROOT_PATH") or define("ROOT_PATH",__DIR__.DS);
defined("BASE_PATH") or define("BASE_PATH",ROOT_PATH.'Base'.DS);
defined("API_PATH") or define("API_PATH",ROOT_PATH.'Api'.DS);
defined("VENDOR_PATH") or define("VENDOR_PATH",ROOT_PATH.'Vendor'.DS);
defined("COF_PATH") or define("COF_PATH",'./Config'.DS);


//启动程序
require_once('Lz/Base/Run.php');

\Base\Run::run();

