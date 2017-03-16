<?php
namespace Base;
// +----------------------------------------------------------------------
// |  	核心运行类：自动加载、参数分发
// +----------------------------------------------------------------------
// | 	Date: 2017-03-05
// +----------------------------------------------------------------------
class Run
{
	static $_map;
	static function run()
	{
		self::init_map();
		//定义加载函数
		spl_autoload_register(array(__CLASS__,'__autoload'));

		self::dispatch();
	}

	static function init_map ()
	{
		$res1 = opendir(ROOT_PATH); 
		while( $dir1 = readdir($res1) )
		{
			if( is_dir(ROOT_PATH.$dir1) && $dir1!=='.' && $dir1!=='..' )
			{
				self::$_map[trim($dir1)] = array();
				$res2 = opendir(ROOT_PATH.$dir1);
				while( $dir2 = readdir( $res2 ) )
				{
					if( is_file( ROOT_PATH.$dir1.DS.$dir2 ) )
					{
						self::$_map[trim($dir1)][] = trim(str_replace('.php', '',$dir2));
					}
				}
			}
		}
		// echo '<pre>';
		// print_r(self::$_map);
	}

	static function __autoload($className) 
	{
		foreach( self::$_map as $k => $v )
		{
			if( in_array(ucwords($className),$v) )
			{
				require_once(ROOT_PATH.$k.DS.$className.EXT);
			}
		}
	}

	static function dispatch() 
	{
		$module = __MODULE__;
		$action = __ACTION__;
		$object = new $module();
		$object->$action();
	}
}