<?php 
class Allow extends Base
{
	public function __construct()
	{
		parent::__construct();
		// S('USER_ID',13);
		//过滤未登录
		if( !S('USER_ID') )
			echoJson(array('status'=>FALSE,'info'=>'000'));
	}
}