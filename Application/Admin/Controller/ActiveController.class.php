<?php 
namespace Admin\Controller;
use Think\Controller;
class ActiveController extends BaseController
{
	public function lst()
	{
		$model = D('Active');
		$data = $model->search();
		$this->assign(array(
			'_page_title'		=>	'活动列表',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'添加活动',
			'data'				=>	$data['data'],
			'page'				=>	$data['page'],
			));

		$this->display();
	}

	public function add()
	{
		if( IS_POST )
		{
			//实例化模型类
			$model = D('Active');

			if( $model->create( I('post.'),1 ) )
			{
				if( $model->add() )
				{
					$this->success('活动添加成功！',U('lst'));
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
				exit;
			}
		}
		else
		{
			$this->assign(array(
				'_page_title'		=>	'添加活动',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'活动列表',
				));

			$this->display();			
		}
	}

	public function del()
	{
		$id = I('get.id');

		//实例化模型类
		$model = D('Active');
		if( $id )
		{
			if( $model->delete($id) )
			{
				$this->success('删除成功！',U('lst'));
				exit;
			}
			else
			{
				$this->error( $model->getError() );
			}
		}
		else
		{
			$this->error('有Bug  联系老周');
		}
	}

	public function edit()
	{
		$model = D('Active');
		if( IS_POST )
		{

			if( $model->create( I('post.'),2 ) )
			{
				if( $model->save() )
				{
					$this->success( '修改活动成功！',U('lst') );
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
			//提取当前数据
			//id 
			$id = I('get.id');
			$info = $model->field('id,title,pic,object,start_time,end_time,location,join_num,is_top,is_show,status,create_time,intro')
						  ->find( $id );

 			$this->assign(array(
			'_page_title'		=>	'修改活动',
			'_page_btn_link'	=>	U('lst'),
			'_page_btn_name'	=>	'活动列表',

			'info'				=>	$info,
				));
			$this->display();
		}
	}
}