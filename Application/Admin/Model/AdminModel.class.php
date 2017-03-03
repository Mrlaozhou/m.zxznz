<?php 
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model
{
	protected $insertFields = array('username','password');
	protected $updataFields = array('id','username','password');

	protected $validate = array(
		array('username','require','账号不能为空',1),
		array('password','reuqire','密码不能为空',1),
		);
	protected function _before_insert(&$data,$options)
	{
		$data['password'] = md5($data['password']);
	}
	protected function _after_insert($data,$options)
	{
		//接收admin_role 信息
		$roleIds = I('r_id');

		//判断有效性
		if ( $roleIds )
		{
			//实例化admin_role 模型类
			$ARmodel = M('admin_role');

			//循环添加
			foreach($roleIds as $k => $v )
			{
				$ARmodel->add(array(
					'admin_id'		=>	$data['id'],
					'role_id'		=>	$v,
					));
			}			
		}
	}

    protected function _before_update(&$data,$option) 
    {
    	//判断密码是否为空
    	if( empty($data['password']) )
    	{
    		//保持原来密码
    		unset($data['password']);
    	}
    	else
    	{
    		$data['password'] = md5( $data['password'] );
    	}


    	/**********************/
    	//处理连表中信息
    	//实例化模型类
    	$ARmodel = M('admin_role');
    	//删除之前信息
		$ARmodel->where(array(
		    		'admin_id'	=>	array('eq',$option['where']['id']),
		    		))->delete();

    	//接收新信息 Id
    	$ids = I('post.rid');

    	//判断
    	if( $ids )
    	{
	    	//循环添加
	    	foreach( $ids as $k => $v )
	    	{
	    		$ARmodel->add(array(
	    			'admin_id'		=>	$option['where']['id'],
	    			'role_id'		=>	$v,
	    			));
	    	}    		
    	}
    }

    protected function _after_update($data,$option) 
    {
  		//   	dump($data);
		// array(3) {
		//   ["username"] => string(6) "admin1"
		//   ["password"] => string(32) "202cb962ac59075b964b07152d234b70"
		//   ["id"] => int(1)
		// }
  		//   	dump($option);
		// array(3) {
		//   ["table"] => string(9) "zxznz_admin"
		//   ["model"] => string(5) "Admin"
		//   ["where"] => array(1) {
		//     ["id"] => int(1)
		//   }
		// } 
	   	// exit;
    	

    	/**********************/
    }
    protected function _before_delete($option)
    {
    	// dump($option);
		// array(3) {
		//   ["where"] => array(1) {
		//     ["id"] => int(5)
		//   }
		//   ["table"] => string(9) "zxznz_admin"
		//   ["model"] => string(5) "Admin"
		// }
    	
    	/***********************/
    	//删除admin_role 中的信息
    	$ARmodel = D('admin_role');

    	$ARmodel->where(array(
    		'admin_id'		=>	array('eq',$option['where']['id']),
    		))->delete();
    }
	public function getJoin()
	{
		return $this->alias('a')
					->field('a.id,a.username,a.password,GROUP_CONCAT(role_name) role_names')
					->join('LEFT JOIN zxznz_admin_role as ar ON a.id = ar.admin_id')
					->join('LEFT JOIN zxznz_role as r ON ar.role_id = r.id')
					->where('a.id != 1')
					->group('a.id')
					->select();
	}
	public function getInfo()
	{
		//接收 Id
		$id = I('get.id');

		//连表取出数据
		return	$this->alias('a')
					 ->field('a.id,a.username,a.password,GROUP_CONCAT(ar.role_id) role_ids')
					 ->join('LEFT JOIN zxznz_admin_role as ar ON a.id = ar.admin_id')
					 ->find($id);
	}
	public function chk_login($arr)
	{
		//防止sql 注入
		$arr = preventXSS($arr);

		//
		$info = $this->where(array(
			'username'		=>	$arr['username'],
			))
					 ->find();

		if( $info ) 
		{
			if( $info['password'] == md5($arr['password']) )
			{
				session('admin_id',$info['id']);
				session('admin_name',$info['username']);
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return -7;
		}
	}
	public function chk_pri()
	{
		//得到当前管理员的信息
		$data =	$this->alias('a')
					 ->field('ar.admin_id,ar.role_id,r.role_name,p.pri_name,rp.pri_id,p.module_name,p.controller_name,p.action_name')
					 ->join('zxznz_admin_role as ar ON a.id = ar.admin_id')
					 ->join('zxznz_role as r ON ar.role_id = r.id')
					 ->join('zxznz_role_pri as rp ON r.id = rp.role_id')
					 ->join('zxznz_privilege as p ON rp.pri_id = p.id')
					 ->where(array(
					 	'a.id'		=>	array('eq',session('admin_id')),
					 	))
					 ->select();
		$result = array();
		//数据处理
		foreach($data as $k => $v)
		{
			$result[$v['pri_name']] = $v['module_name'].'-'.$v['controller_name'].'-'.$v['action_name'];
		}	

		return $result;
	}
}

