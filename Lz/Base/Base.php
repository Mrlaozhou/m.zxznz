<?php
// 网站根目录
define('__ROOT__',__DIR__);
class Base
{
	static $_db;
	public function __construct()
	{
		$this->init_func();
		$this->init_header();
	}

	private function init_func()
	{
		require_once(__ROOT__.'/Config/functions.php');
	}
	public function init_header()
	{
		header("Access-Control-Allow-Origin:".ALLOW_HOST);
	}

}
