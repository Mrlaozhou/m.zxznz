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
		$info = $this->isExists($username);
		if( $info === FALSE )
			echoJson(array('status'=>FALSE,'info'=>'!003'));

		//密码错误
		if( $info['password'] != md5($password) )
			echoJson(array('status'=>FALSE,'info'=>'002'));

		//登录、储存用户信息
		S('USER_ID',$info['id']);
		S('USER_NAME',$info['username']);
		S('USER_ALIAS',$info['alias']);
		echoJson(array('status'=>TRUE));
	}

	public function logout()
	{
		//跟新登录时间
		$model = M('User');
		$time = time();
		$id = S('USER_ID');
		$sql = "UPDATE `zxznz_user` SET `last_time` = {$time} WHERE `id` = {$id}";
		$model->exec($sql);
		/*需求介绍*/// 用户登录 Z2hidGJ5Xm4mYXZ0Ynleeg%3D%3D
		S('USER_ID',null);
		S('USER_NAME',null);

	}
	public function isLogin()
	{
		/*需求介绍*/// 用户登录 YXZ0Ynlmdl5uJmF2dGJ5Xno%3D
		if( S('USER_ID') )
			echoJson(array('status'=>TRUE,'USER_ID'=>S('USER_ID'),'USER_NAME'=>S('USER_NAME')));
		echoJson(array('status'=>FALSE));
	}
}
