<?php 
namespace Admin\Controller;
use Think\Controller;
class PrivilegeController extends BaseController
{
	public function lst()
	{
		$model = D('Privilege');
		//获取权限信息
		$data = $model->select();
		$data = getSort($data,0,0,true);

		$this->assign(array(
			'_page_title'		=>	'权限管理',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'添加权限',

			'data'				=>	$data
			));

		$this->display();
	}
	public function add()
	{
		//实例化模型类
		$model = D('Privilege');

		if( IS_POST )
		{
			if ( $model->create( I('post.'),1) ) 
			{	
				if( $model->add() )
				{
					flushMemcache();
					$this->success('添加权限成功！' , U('lst') );
					exit;
				}
				else
				{
					$this->error($model->getError());
				}
			}
			else
			{
				$this->error('权限添加失败！！！');
			}

		}
		else
		{
			/********************************/
			//从数据库中获得上级权限信息
			$ups = $model->field(array('id','pri_name','parent_id'))
				  ->select();

			//转为排序型结构
			$ups = getSort($ups);
			/********************************/

			$this->assign(array(
				'_page_title'		=>	'添加权限',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'权限列表',

				'ups'				=>	$ups,
				));

			$this->display();
		}
	}
	public function edit()
	{
		//实例化模型类
		$model = D('Privilege');

		if( IS_POST )
		{
			if( $model->create( I('post.'),2 ) )
			{
				if( $model->save() !== False )
				{
					flushMemcache();
					$this->success('修改权限成功！',U('lst'));
					exit;
				}
				else
				{
					$this->error($model->getError());
				}
			}
			else
			{
				$this->error($model->getError());
			}
		}
		else
		{
			/********************************/
			//从数据库中获得处下级权限的所有权限信息
			$result = $model->getChildren();
			$result = getSort($result,0,0,true);

			/********************************/
			//接收ＩＤ
			$id = I('get.id');
			$info = $model->find($id);
			

			$this->assign(array(
				'_page_title'		=>	'修改权限',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'权限列表',

				'info'				=>	$info,
				'result'				=>	$result,
				));
			$this->display();
		}
	}
	public function del()
	{
		//接收ID
		$id = I('get.id');

		//实例化模型类
		$model = D('Privilege');

		if( $model->delete($id) !== FALSE )
		{
			flushMemcache();
			echo json_encode(array('result'=>1));
		}
		else
		{
			echo json_encode(array('result'=>'删除失败！'));
		}
	}
}




