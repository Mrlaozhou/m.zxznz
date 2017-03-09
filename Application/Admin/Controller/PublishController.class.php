<?php 
namespace Admin\Controller;

class PublishController extends BaseController
{
	public function lst()
	{
		$model = D('Publish');
		$data = $model->field('id,title,begin,action,is_show,create_time,bg,bg_type')
					  ->select();
		$this->assign(array(
			'_page_title'		=>	'发布管理',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'创建发布',

			'data'				=>	$data,
			));

		$this->display();
	}
	public function add()
	{
		if( IS_POST )
		{
			//实例化model
			$model = D('Publish');

			if( $model->create( I('post.'),1 ) )
			{
				if( $model->add() !== FALSE )
				{
					$this->success('添加发布成功！',U('lst'));
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
			$this->assign(array(
				'_page_title'		=>	'创建发布',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'发布列表',
				));

			$this->display();	
		}
	}
	public function edit()
	{
		//实例化model
		$model = D('Publish');
		if( IS_POST )
		{
			if( $model->create( I('post.'),2 ) )
			{
				if( $model->save() !== FALSE )
				{
					$this->success('修改发布成功！',U('lst'));
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
			$id = I('get.id');
			$info = $model->field('id,title,intro,begin,action,is_show,bg,bg_type')
						  ->find($id);

			$this->assign(array(
				'_page_title'		=>	'修改发布成功',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'发布列表',

				'info'				=>	$info,
				));

			$this->display();	
		}
	}
	public function del()
	{
		$id = I('get.id');

		if( $id )
		{
			$model = D('Publish');
			
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
			$this->error('有Bug。。赶紧告诉老周');
		}
	}
}