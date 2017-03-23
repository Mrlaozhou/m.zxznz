<?php 

class Test extends Base
{
	public function set()
	{
		if( !isset($_SESSION['admin']['haha']) )
			$_SESSION['admin']['haha'] = time();
		echoJson(array($_SESSION['admin']['haha'],time()));
	}
	public function get()
	{
		echoJson(array($_SESSION['admin']['haha'],time()));
	}
}