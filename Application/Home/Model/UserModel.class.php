<?php 
namespace Home\Model;
use Think\Model;

class UserModel extends Model
{
	protected $insertFields = array('username','password','e-mail','create_time');
	protected $updateFields = array('id','username','password','last_time');
	protected $_validate = array(
		array('username' , 'require' , '用户名不能为空' , 1),
		array('username' , 'checkUser' , '用户名已经存在' , 2,'callback'),
		array('e-mail' , 'email' , '邮箱格式不正确' , 1),
		);

	protected function _before_insert(&$data,$options)
	{
		/*
			dump($data);
			array(2) {
				  ["username"] => string(7) "laozhou"
				  ["e-mail"] => string(15) "zgs5999@163.com"
				}
		*/
		/*
			dump($options);
			array(2) {
			  ["table"] => string(8) "emp_user"
			  ["model"] => string(4) "User"
			}
		*/		
		//$data['create_time'] = time();
		/*
			dump($data);
			array(3) {
			  ["username"] => string(7) "laozhou"
			  ["e-mail"] => string(15) "zgs5999@163.com"
			  ["create_time"] => int(1482742177)
			}
		*/
		
		//获得随机密码
		$password = getRandStr(6,1);

		//把密码发送给用户
		$result = sendEmail('上海纽珀' , '您的六位数密码为：&nbsp;&nbsp;&nbsp;'.$password , $data['e-mail']);

		//判断如果发送成功 , 把用户信息存入数据库
		if ( $result === true )
		{
			$data['create_time'] = time();
			$data['last_time'] 	 = time();
			$data['password']	 = md5(trim($password));
		}
		else
		{
			//定义错误信息
			$this->error = $result;
			return false;
		}
	}
	protected function _after_insert($data,$options)
	{}

	/**
	 * [checkUser 检验用户名是否已经注册
	 * @return [type] [description]
	 */
	public function checkUser($username)
	{
		$data = $this->where(array(
			'username'=> array('eq',$username),
			))->find();
		return $result = $data ? false : true;
	}

	/**
	 * [checkLogin 验证用户登录]
	 * @param  [type] $arr [登录信息]
	 * @return [type]      [status]
	 */
	public function checkLogin($arr)
	{
		//防止sql注入
		$arr = preventXSS($arr);

		//验证是否存在此用户
		$data = $this->field('id,username,password')
					 ->where(array(
					 	'username' => array('eq',$arr['username']),
					 	))
					 ->find();

		// dump($data);
		// exit;
		//如果存在此条信息，该用户名有效
		if ( $data )
		{
			//判断密码是否正确 && 双重判断用户名
			if ( $data['password'] === md5($arr['password']) && $data['username'] == $arr['username'])
			{
				//密码正确,信息存入session，返回 1
				session('user_id',$data['id']);
				session('user_name',$data['username']);
				return 1;
			}
			else
			{
				//密码错误，返回 -7
				return -7;
			}
		}
		else
		{
			//不存在此用户，返回 0
			return 0;
		}
	}
} 