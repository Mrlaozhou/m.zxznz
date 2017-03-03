<?php 
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
	protected $insertFields = array('role_name');
	protected $updataFields = array('id','role_name');

	protected $_validate = array(
		array('role_name','require','角色名称不能为空！',1),
		);

	protected function _before_insert(&$data,$options)
	{

	}
	protected function _after_insert($data,$options)
	{
		// dump($data);
		// array(2) {
		//   ["role_name"] => string(15) "角色管理员"
		//   ["id"] => int(2)
		// } 

		// dump($options);
		// array(2) {
		//   ["table"] => string(8) "zxznz_role"
		//   ["model"] => string(4) "Role"
		// }

		/*********************/
		//把每一个角色所对应的  权限ＩＤ存入 zxznz_role_pri 表
		//实例化模型类
		$RPmodel = M('role_pri');
		//接收权限IDs 
		$priIds = I('pri_id');
		//判断是否存在权限Ids
		if ($priIds)
		{
			//循环添加
			foreach( $priIds as $k => $v )
			{
				$RPmodel -> add(array(
					'role_id'	=>	$data['id'],
					'pri_id'	=>	$v
					));
			}			
		}
	}

	protected function _before_update(&$data,$option)
	{
		//实例化 权限模型类
		$RPmodel = M('role_pri');

		/********************/
		//删除当前角色下的权限信息
		$RPmodel->where(array(
			'role_id'		=>	array('eq',$option['where']['id']),
			))
			   ->delete();
		//更新权限信息  到当前角色下
		//接收权限 Ids
		$priIds = I('post.pri_id');

		//判断
		if( $priIds )
		{
			foreach($priIds as $k => $v)
			{
				$RPmodel->add(array(
					'role_id'		=>	$option['where']['id'],
					'pri_id'		=>	$v,
					));
			}
		}
	}

	public function getJoin()
	{
		return $this->alias('r')
				 	->field('r.id,r.role_name,GROUP_CONCAT(p.pri_name) pri_names')
				 	->join('LEFT JOIN zxznz_role_pri as rp ON r.id = rp.role_id')
				 	->join('LEFT JOIN zxznz_privilege as p ON rp.pri_id = p.id')
				 	->group('r.id')
				 	->select();
	}

	public function getInfo()
	{
		//接收 Id
		$id = I('get.id');

		//与  role_pri 表联合查出信息
		return	$this->alias('r')
					 ->field('r.id,r.role_name,GROUP_CONCAT(rp.pri_id) priIds')
					 ->join('LEFT JOIn zxznz_role_pri as rp ON r.id = rp.role_id')
					 ->where(array(
					 	'r.id'	=>	array('eq',$id),
					 	))
					 ->find();
	}

}
