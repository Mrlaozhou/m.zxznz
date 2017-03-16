<?php 


class Db
{
	private $_config;
	private $_link;

	public function __construct()
	{
		$this->InitConfig();
		$this->InitLink();
		$this->InitChoose();
		$this->InitChar();
	}

	private function __clone() {}

	private function InitConfig()
	{
		$this->_config = require_once('/Config/configs.php');
	}

	private function InitLink()
	{
		// $this->_link = @mysql_connect($this->_config['host'],"root","laozhou") or Error("数据库连接异常");
		$this->_link = new PDO('mysql:host=localhost;dbname='.DB_NAME, "'".DB_ROOT."'", 'laozhou', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
	}
	private function InitChoose()
	{
		$sql = "use ".DB_NAME;
		$result = $this->query($sql) or Error("选择数据库出错");
	}
	private function InitChar()
	{
		$sql = "set names {$this->_config['char']}";
		$this->query($sql) or Error("选择数据库语言出错");
	}

	public function query($sql)
	{
		return $this->_link->query($sql);
	}

	public function exec($sql)
	{
		return $this->_link->exec($sql);
	}
}
