<?php 
namespace Admin\Controller;
use Think\Controller;

class TypeController extends BaseController
{
	public function lst()
	{
		$model = D('Type');
		$data = $model->field('id,type_name,parent_id')
					 ->select();

		//处理数据为排序型
		$data = getSort($data);

		$this->assign(array(
			'_page_title'		=>	'医院分类管理',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'添加医院分类',

			'data'				=>	$data,
			));

		$this->display();
	}


	public function add()
	{
		$model = D('Type');
		
		if( IS_POST )
		{

			if( $model->create( I('post.'),1 ) )
			{

				if( $model->add() !== FALSE )
				{
					$this->success('添加分类成功！',U('lst'),1);
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
			$ups = $model->field('id,type_name,parent_id')
						 ->select();

			//处理数据为排序型
			$ups = getSort($ups);

			$this->assign(array(
				'_page_title'		=>	'添加分类管理',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'医院分类列表',

				'ups'				=>	$ups,
				));

			$this->display();			
		}
	}
	public function del()
	{
		//接收ID
		$id = I('get.id');

		//实例化模型类
		$model = D('Type');

		if( $model->delete($id) !== FALSE )
		{
			echo json_encode(array('result'=>1));
		}
		else
		{
			echo json_encode(array('result'=>'删除失败！'));
		}
	}
	public function edit()
	{
		$model = D('Type');
		if( IS_POST )
		{
			if( $model->create( I('post.'),2 ) )
			{
				if( $model->save() !== FALSE )
				{
					$this->success('修改分类信息成功！',U('lst'),1);
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
			$id = I('get.id');
			//从数据库中获得处下级权限的所有权限信息
			$result = $model->getChildren();
			$result = getSort($result,0,0,true);

			$info = $model->field('id,type_name,parent_id')->find($id);

			$this->assign(array(
			'_page_title'		=>	'修改医院分类',
			'_page_btn_link'	=>	U('lst'),
			'_page_btn_name'	=>	'医院分类列表',

			'info'				=>	$info,
			'result'			=>	$result,
			));

			$this->display();
		}
	}
}