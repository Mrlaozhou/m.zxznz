<?php 
// +----------------------------------------------------------------------
// | 登录、注册父类
// +----------------------------------------------------------------------

class Check extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	public function isExists($username)
	{
		//ZmdmdmtyXm4meHBydXBeeg%3D%3D
		$model = M('User');
		$sql = "SELECT id,username,password,alias FROM `zxznz_user` WHERE `username` = '{$username}'";

		$info = $model->One($sql);
		
		if( $info )
			return $info;
		else
			return FALSE;
	}

	public function CheckPwd($pwd)
	{
		if( !Unsign($pwd) )
			return 1;//不合法
		$len = strlen($pwd);
		if( $len < 6 || $len > 12 )
			return 2;//长度不合法
		return TRUE;
	}
}