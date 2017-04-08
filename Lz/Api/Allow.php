<?php 
class Allow extends Base
{
	public function __construct()
	{
		parent::__construct();
		// S('USER_ID',13);
		
		/*访问权限控制*///

		#定义开放路由列表#
		$ALLOW = array(
				'Order'=>array('aliGet','wxGet'),
				);

		// dump(__MODULE__,2);

		//判断是否在列表中
		if( isset( $ALLOW[__MODULE__] ) )
		{
			if( in_array(__ACTION__,$ALLOW[__MODULE__]) === FALSE )
			{
				if( !S('USER_ID') )
					echoJson(array('status'=>FALSE,'info'=>'000'));			
			}
		}
		else
		{
			if( !S('USER_ID') )
				echoJson(array('status'=>FALSE,'info'=>'000'));
		}
	}
}