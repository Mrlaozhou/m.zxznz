<?php 
class Register extends Check
{
	public function exists()
	{
		/*需求介绍*/// 用户名是否存在 ZmdmdmtyXm4mZXJnZnZ0cmVeeg%3D%3D
		$mobile = P('mobile');
		if( !$mobile )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		$result = $this->isExists($mobile);
		if( $result === FALSE )
			echoJson(array('status'=>TRUE));
		echoJson(array('status'=>FALSE,'info'=>'003'));
	}
	public function sendMSG()
	{
		/*需求介绍*/// 发送短信 VEZacWFyZl5uJmVyZ2Z2dHJlXno%3D
		//接受参数
		$mobile = P('mobile');
		if( !$mobile )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		/*1.*///验证用户是否注册
		$is = $this->isExists($mobile);
		// dump($is);
		//已注册
		if( $is !== FALSE )
			echoJson(array('status'=>FALSE,'info'=>'003'));

		//未注册,判断是否发送过验证码
		if( $code = S('code_'.$mobile) )
		{
			//已经发送验证短信,是否过期
			$msg = explode('-',$code);
			$offset = time()-(int)$msg[1];

			if( $offset < 1800 )
				//不过期
				echoJson(array('status' =>FALSE,'info'=>'003&!007','remark' =>$offset));
			else
				//过期重发
				S('code_'.$mobile,null);
			$this->sendMSG();
		}
			
		//短信接口地址
		$url = 'http://106.ihuyi.com/webservice/sms.php?method=Submit';

        //账户、密码
        $account = 'C22986809';
        $password = '37454a5b2e36e986562439659c74c928';

        //生成随机验证码
        $rand = getRandStr(4,2);
        
        $post_data = "account={$account}&password={$password}&mobile={$mobile}&content=".rawurlencode("您的验证码是：{$rand}。请不要把验证码泄露给其他人。");

        /*|发送验证码|*/
        $result = POST($post_data,$url);

        //处理数据
        $result = simplexml_load_string($result);

        if( $result->code == 2 )
        {
        	//发送成功，储存信息
        	S('code_'.$mobile,$rand.'-'.time());

        	echoJson(array('status'=>TRUE));
        }
        else
        {
        	echoJson(array('status'=>FALSE,'info'=>'444'));  
        }
	}
	public function checkCode()
	{
		//echoJson(array('status'=>TRUE));
		/*需求介绍*/// 验证密码 cnFiUHhwcnVwXm4mZXJnZnZ0cmVeeg%3D%3D
		$code = P('code');
		$mobile = P('mobile');

		// S('code_'.$mobile,'1234'.'-'.time());
		// exit;
		//检验用户是否注册
		if( $this->isExists($mobile) !== FALSE )
			echoJson(array('status'=>FALSE,'info'=>'003','remark'=>'此用户已经注册'));

		//传参出错
		if( !$code && !$mobile )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		//未发送过验证码
		if( !S('code_'.$mobile) )
			echoJson(array('status'=>FALSE,'info'=>'002&006'));
		//已发送
		$msg = explode('-',S('code_'.$mobile));
		$offset = time()-$msg[1];
		//验证码未超时
		if( $offset <= 1800 )
		{
			//判断验证码是否正确
			//true
			if( $code == $msg[0] )
			{
				//置空 sesison
				S('code_'.$mobile,null);
				echoJson(array('status'=>TRUE));
			}
			//false
			echoJson(array('status'=>FALSE,'info'=>'002'));
		}
		else
		{
			//验证码超时
			//置空 sesison
			S('code_'.$mobile,null);
			echoJson(array('status'=>FALSE,'info'=>'007'));
		}
	}
	public function alias()
	{
		/*需求介绍*/// 验证别名 Zm52eW5ebiZlcmdmdnRyZV56 
		//接受参数
		$alias = P('alias');

		//传参出错
		if( !$alias )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		//参数不合法
		if( !Unsign($alias) )
			echoJson(array('status'=>FALSE,'info'=>'002'));

		$len = strlen($alias);
		//长度不合法
		if( $len < 3 || $len > 20 )
			echoJson(array('status'=>FALSE,'info'=>'005'));
		echoJson(array('status'=>TRUE));
	}
	public function pwd()
	{
		/*需求介绍*/// 验证密码 cWpjXm4mZXJnZnZ0cmVeeg%3D%3D
		$pwd = P('pwd');

		//传参出错
		if( !$pwd )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		$result = $this->checkPwd($pwd);
		//dump($result);
		
		if( $result === TRUE )
			echoJson(array('status'=>TRUE));
		if( $result === 1 )
			echoJson(array('status'=>FALSE,'info'=>'002'));
		echoJson(array('status'=>FALSE,'info'=>'005'));
	}
	public function repeat()
	{
		/*需求介绍*/// 验证密码 Z25yY3JlXm4mZXJnZnZ0cmVeeg%3D%3D
		$new = P('new');
		$old = P('old');

		//传参出错
		if( !$new && !$old )
			echoJson(array('status'=>FALSE,'info'=>'001'));

		//验证合法性
		$result = $this->checkPwd($old);

		if( $result === 1 )
			echoJson(array('status'=>FALSE,'info'=>'002'));
		if( $result === 2 )
			echoJson(array('status'=>FALSE,'info'=>'005'));

		//验证相等
		if( $new === $old )
			echoJson(array('status'=>TRUE));
		echoJson(array('status'=>FALSE,'info'=>'!003'));
	}
	public function enroll()
	{
		/*需求介绍*/// 用户注册 eXliZWFyXm4mZXJnZnZ0cmVeeg%3D%3D
		//接收参数
		$phone = P('phone') ? P('phone') : echoJson(array('status'=>FALSE,'info'=>'001'));
		$alias = P('alias') ? P('alias') : echoJson(array('status'=>FALSE,'info'=>'001'));
		$new   = P('new') 	? P('new') 	 : echoJson(array('status'=>FALSE,'info'=>'001'));
		$old   = P('old') 	? P('old')   : echoJson(array('status'=>FALSE,'info'=>'001'));

		//判断用户名
		if( $this->isExists($phone) !== FALSE )
			echoJson(array('status'=>FALSE,'remark'=>'1'));

		//判断别名
		$len = strlen($alias);
		if( !Unsign($alias) || ($len<3) || ($len>30) )
			echoJson(array('status'=>FALSE,'remark'=>'2'));

		//验证密码
		if( $this->checkPwd($old) !== TRUE )
			echoJson(array('status'=>FALSE,'remark'=>'3'));

		//确认密码
		if( $new !== $old )
			echoJson(array('status'=>FALSE,'remark'=>'4'));

		//存储信息
		$create_time = time();
		$password = md5($old);
		$sql = "INSERT INTO `zxznz_user` (username,password,alias,create_time) VALUES('{$phone}','{$password}','{$alias}',{$create_time})";
		$model = M('User');

		if( $model->exec($sql) === 1 )
			echoJson(array('status'=>TRUE));
		echoJson(array('status'=>FALSE));
	}
}