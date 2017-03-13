<?php
class Base
{
	static $_db;
	public function __construct()
	{
		$this->init_func();
	}

	private function init_func()
	{
		require_once('/Config/functions.php');
	}
	public function init_header()
	{
		header("Access-Control-Allow-Origin:".ALLOW_HOST);
	}

}
