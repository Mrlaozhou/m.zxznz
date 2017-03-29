<?php 

class Login extends Check
{
	public function entry()
	{
		/*需求介绍*/// 用户登录 bGVnYXJebiZhdnRieV56
		$username = P('username');
		$password = P('password');

		//传参出错
		if( !$username && !$password )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		//用户名不存在
		if( $info = $this->isExists($username) !== FALSE )
			echoJosn(array('status'=>FALSE,'info'=>'!003'));

		//密码错误
		if( $info['password'] !== md5($password) )
			echoJosn(array('status'=>FALSE,'info'=>'002'));

		//登录、储存用户信息
		S('USER_ID',$info['id']);
		S('USER_NAME',$info['username']);
		echoJosn(array('status'=>TRUE));
	}

	public function logout()
	{
		/*需求介绍*/// 用户登录 Z2hidGJ5Xm4mYXZ0Ynleeg%3D%3D
		S('USER_ID',null);
		S('USER_NAME',null);
	}
}
