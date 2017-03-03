<?php 
namespace Admin\Controller;
use Think\Controller;
class RoleController extends BaseController
{
	public function lst()
	{
		//实例化，模型类
		$model = D('Role');
		//取出数据
		$data = $model->getJoin();
		$this->assign(array(
			'_page_title'		=>	'角色管理',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'添加角色',

			'data'				=>	$data,
			));

		$this->display();
	}
	public function add()
	{
		//实例化当前模型
		$model = D('Role');

		if ( IS_POST )
		{
			if ( $model->create( I('post.'),1 ) )
			{
				if ( $model->add() )
				{
					flushMemcache();
					$this->success('角色添加成功！',U('lst'));
					exit;
				}
			}
			else
			{
				$this->error( $model->getError() );
			}
		}
		else
		{
			/******************************/
			//实例化权限类
			$priModel = D('Privilege');
			//取出权限数据
			$priData = $priModel->field(array('id','pri_name','parent_id'))
					 ->select();
			//处理数据为  排序型
			$priData = getSort($priData);
			/******************************/
			 
			$this->assign(array(
				'_page_title'		=>	'角色管理',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'角色列表',

				'priData'			=>	$priData,
				));

			$this->display();
		}
	}
	public function edit()
	{
		//实例化当前模型类
		$model = D('Role');

		if ( IS_POST )
		{
			if( $model->create( I('post.'),2 ) )
			{
				if( $model->save() !== FALSE)
				{
					flushMemcache();
					$this->success('修改角色信息成功！',U('lst'));
					exit;
				}
			}
			else
			{
				$this->error( $model->getError() );
			}
		}
		else
		{
			/***********************/
			//实例化权限模型类，取出所有权限
			$Pmodel = D('Privilege');
			$priData = $Pmodel->select();
			//数据处理成 排序型
			$priData = getSort($priData);
			/***********************/
			//取出当前的信息，展示到模板
			$info = $model->getInfo();
			// dump($info);
			// dump(explode(',',$info['priIds']));
			// exit;

			$this->assign(array(
				'_page_title'		=>	'修改角色',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'角色列表',

				'priData'			=>	$priData,
				'info'				=> 	$info,
				'priIds'			=>	explode(',',$info['priIds'])
				));
			$this->display();
		}
	}
	public function del()
	{
		//接收 Id
		$id = I('get.id');

		//实例化模型类
		$model = D('Role');

		if ( $model->delete($id) !== FALSE )
		{
			flushMemcache();
			$this->success('删除角色成功！',U('lst'));
			exit;
		}
		else
		{
			$this->error($model->getError());
		}
	}
}
