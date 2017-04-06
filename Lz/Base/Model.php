<?php 
class Model
{
	static private $_db;
	static private $_table;
	static private $_fields;
	public function __construct($table)
	{
		self::InitDb();
		self::InitTable(trim($table));
		// self::InitFields();
	}

	static private function InitDb()
	{
		self::$_db instanceof Db ?  "" : self::$_db = new Db();
	}
	static private function InitTable($table)
	{
		$sql = "DESC ".DB_NAME."_{$table}";
		self::$_db->query($sql) ? self::$_table = DB_NAME.'_'.$table : Error('无效表名');;
	}
	static private function InitFields()
	{
		$sql = "DESC ".self::$_table;
		$data = self::$_db->query($sql)->fetchAll();
		$result = array();
		foreach($data as $k => $v)
		{
			if( $v['Field'] )
				if( $v['Key'] == 'PRI')
					$result['PRI'] = $v['Field'];
				else
					$result[] = $v['Field'];
		}
		self::$_fields = $result;
	}
	static private function parseConfig($config)
	{

	}
	/*****************************************/

	public function exec($sql)
	{
		return self::$_db->exec($sql);
	}

	public function One($sql)
	{
		$ps = self::$_db->query($sql);
		return $ps->fetch(PDO::FETCH_ASSOC);
	}

	public function All($sql)
	{
		$ps = self::$_db->query($sql);
		return $ps->fetchAll(PDO::FETCH_ASSOC);
	}
	public function lastInsertId()
	{
		return self::$_db->lastInsertId();
	}
	/*****************************************/
}