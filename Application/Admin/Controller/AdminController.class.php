<?php 
namespace Admin\Controller;
use Think\Controller;

class AdminController extends BaseController
{
	public function lst()
	{
		//实例化模型类
		$model = D('Admin');
		$data = $model->getJoin();

		$this->assign(array(
			'_page_title'		=>	'管理员管理',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'添加管理员',

			'data'				=>	$data,

			));
		$this->display();
	}
	public function add()
	{
		//实例化当前类
		$model = D('Admin');

		if( IS_POST )
		{
			if ( $model->create( I('post.'),1 ) ) 
			{
				if ( $model->add() )
				{
					flushMemcache();
					$this->success('创建管理员成功！',U('lst'));
					exit;
				}
				else
				{
					$this->error( $model->getError() );
				}
			}
			else
			{
				$this->error( $model->getError() );
			}
		}
		else
		{
			/**************************/
			//实例化Role模型类
			$Rmodel = D('Role');
			$roleData = $Rmodel->select();

			$this->assign(array(
				'_page_title'		=>	'管理员管理',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'管理员列表',

				'roleData'			=>	$roleData,
				));

			$this->display();
		}
	}
	public function del()
	{
		//接收 Id
		$id = I('get.id');

		//实例化模型类
		$model = D('Admin');

		if( $model->delete($id) )
		{
			flushMemcache();
			echo json_encode( array('result'=>1) );
		}
		else
		{
			echo json_encode( array('result'=>0) );
		}
	}
	public function edit()
	{
		//实例化当前模型类
		$model = D('Admin');
		if( IS_POST )
		{
			if( $model->create( I('post.'),2 ) )
			{
				if( $model->save() !== FALSE )
				{
					flushMemcache();
					$this->success('修改管理员信息成功！',U('lst'));
					exit;
				}
			}
			else
			{
				$this->error($model->getError());
			}
		}
		else
		{
			/****************************/


			//取出此条信息
			$info = $model->getInfo($id);

			/****************************/
			//实例化role类，取出角色信息
			$Rmodel = D('Role');
			$roleData = $Rmodel->select();

			$this->assign(array(
				'_page_title'		=>	'编辑管理员',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'管理员列表',

				'info'				=>	$info,
				'roleData'			=>	$roleData,
				'nowRoleIds'		=>	explode(',',$info['role_ids'])
				));
			$this->display();
		}
	}
}

