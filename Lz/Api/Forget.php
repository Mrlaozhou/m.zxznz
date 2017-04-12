<?php 

class Forget extends Check 
{
	public function Exists()
	{
		/*需求介绍*/// 用户登录 ZmdmdmtSXm4mZ3J0ZWJTXno%3D

		//接收参数
		if( ! $username = P('username') )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		//判断是否存在
		$info = $this->isExists($username);

		//不存在
		if( $info === FALSE )
			echoJson(array('status'=>FALSE,'info'=>'!003'));

		//存在
		echoJson(array('status'=>TRUE));
	}
	public function sendMSG()
	{
		/*需求介绍*/// 发送重置密码验证码 VEZacWFyZl5uJmdydGViU156
		if ( ! $phone = P('phone') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		$info = $this->isExists($phone);
		//判断用户是否存在
		if ( $info === FALSE )
			echoJson(array('status'=>FALSE,'info'=>'!003'));

		/**///验证是否已发送过
		//发送过
		if( $code = S('FORGET_CODE'.'_'.$phone) )
		{
			//取出时间偏移量
			$msg = explode('-',$code);
			$offset = time()-$msg[1];
			/**///验证是否过期
			//未过期
			if( $offset < 1800 )
				echoJson(array('status' =>FALSE,'info'=>'003&!007'));
		}

		/**///发送、重新发送

		//生成随机验证码
        $rand = getRandStr(4,2);
		//短信接口地址
		$url = 'http://106.ihuyi.com/webservice/sms.php?method=Submit';

        //账户、密码
        $account = 'C22986809';
        $password = '37454a5b2e36e986562439659c74c928';

        $post_data = "account={$account}&password={$password}&mobile={$phone}&content=".rawurlencode("您的验证码是：{$rand}。请不要把验证码泄露给其他人。");

        /*|发送验证码|*/
        $result = POST($post_data,$url);

        //处理数据
        $result = simplexml_load_string($result);

        if( $result->code == 2 )
        {
        	//发送成功，储存信息
        	S('FORGET_CODE'.'_'.$phone,$rand.'-'.time());
        	echoJson(array('status'=>TRUE));
        }
        else
        {
        	echoJson(array('status'=>FALSE,'info'=>'444'));  
        }
	}
	public function checkCode()
	{
		/*需求介绍*/// 验证码验证  cnFiUHhwcnVwXm4mZ3J0ZWJTXno%3D 
		/**///接收参数

		$phone = P('phone') ? P('phone') 	: echoJson(array('status'=>FALSE,'info'=>'001'));
		$code  = P('code') 	? P('code') 	: echoJson(array('status'=>FALSE,'info'=>'001'));

		/**///判断验证码
		$msg = explode('-',S('FORGET_CODE'.'_'.$phone));
		$rand = $msg[0];

		//验证码错误
		if ( $code != $rand )
			echoJson(array('status'=>FALSE,'info'=>'002'));
		//认证传递
		S('FORGET_CODE'.'_'.$phone,null);
		S('ALLOW'.'_'.$phone,'OK');
		echoJson(array('status'=>TRUE));
	}
	public function reset()
	{
		/*需求介绍*/// 重置密码 Z3JmcmVebiZncnRlYlNeeg%3D%3D 
		//接收参数
		$username = P('username') 	? P('username') : echoJson(array('status'=>FALSE,'info'=>'001'));
		$pwd_1	  = P('pwd_1') 		? P('pwd_1') 	: echoJson(array('status'=>FALSE,'info'=>'001'));
		$pwd_2 	  = P('pwd_2') 		? P('pwd_2') 	: echoJson(array('status'=>FALSE,'info'=>'001'));
		$code  	  = P('code') 		? P('code')   	: echoJson(array('status'=>FALSE,'info'=>'001'));
		//dump(S('ALLOW'.'_'.$username));

		//非法（验证码验证未通过）
		if ( S('ALLOW'.'_'.$username) !== 'OK' )
			echoJson(array('status'=>FALSE,'info'=>'400'));

		/**///判断密码
		if ( $this->checkPwd($pwd_1) !== TRUE )
			echoJson(array('status'=>FALSE,'info'=>'002','remark'=>'密码格式错误！'));
		if ( $pwd_1 != $pwd_2 )
			echoJson(array('status'=>FALSE,'info'=>'002','remark'=>'两次密码不相同！'));

		#########重置密码##########
		$truePass = md5($pwd_2);

		$model = M('User');
		$sql = "UPDATE `zxznz_user` SET `password`= '{$truePass}' WHERE `username` = '{$username}'";
		//dump($sql);
		$info = $model->exec($sql);

		if ( $info === FALSE )
			echoJson(array('status'=>FALSE,'info'=>'444'));

		//清空 S
		S('ALLOW'.'_'.$username,null);
		echoJson(array('status'=>TRUE));
	}
}