<?php 
namespace Home\Model;
use Think\Model;

class UserModel extends Model
{
	protected $insertFields = array('username','password','alias','create_time','last_time');
	protected $updateFields = array('id','username','password','alias','create_time','last_time');
	protected $_validate = array();

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