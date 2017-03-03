<?php 
namespace Admin\Controller;
use Think\Controller;
class DoctorController extends BaseController
{
	public function lst()
	{
		//接收医院ID
		$hos_id = I('get.hos_id');

		//根据hos_id 查出此医院下所有的 医生 信息
		$model = D('doctor');

		//获取数据
		$data = $model->search();


		$this->assign(array(
			'_page_title'		=>		'医生列表',
			'_page_btn_link'	=>		U('add?hos_id='.$hos_id),  
			'_page_btn_name'	=>		'添加医生',

			'infos'				=>		$data['infos'],
			'page'				=>		$data['page'],
			));
		$this->display();
	}

	public function add()
	{
		//实例化模型类
		$model = D('Doctor');
		if( IS_POST )
		{
			
			if( $result = $model->create( I('post.'),1 ) )
			{
				if( $model->add() !== FALSE )
				{
					$this->success('添加医生信息成功！',U('lst?hos_id='.$result['hos_id']));
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
			//接收医院Id
			$hos_id = I('get.hos_id');

			$this->assign(array(
				'_page_title'		=>	'添加医生',
				'_page_btn_link'	=>	U('lst?hos_id='.$hos_id),
				'_page_btn_name'	=>	'医生列表',

				'hos_id'			=>	$hos_id,
				));
			$this->display();
		}
	}

	public function edit()
	{
		//实例化模型类
		$model = D('Doctor');

		if( IS_POST )
		{
			if( $result = $model->create( I('post.'),2 ) )
			{
				if( $model->save($result) !== FALSE )
				{
					$this->success('修改成功！',U('lst?hos_id='.$result['hos_id']));
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
			//接收当前ID
			$id = I('get.id');

			//取出当前数据
			$info = $model->field('*')
						  ->find($id);

			$this->assign(array(
				'_page_title'		=>	'修改医生信息',
				'_page_btn_link'	=>	U('lst?hos_id='.$info['hos_id']),
				'_page_btn_name'	=>	'医生列表',

				'info'				=>	$info,
				));
			$this->display();
		}
	}

	public function ajaxDelDoctor()
	{
		//接收ID
		$id = I('get.id');

		//实例化模型类
		$model = D('Doctor');

		if($model->delete($id))
		{
			echo json_encode(array('result'=>1));
		}
		else
		{
			echo json_encode(array('result'=>0));
		}
	}
	public function ajaxRefreshDocTop()
	{
		if( IS_AJAX )
		{
			$id = I('get.id');
			if( $id )
			{
				//实例化hospital model 
				$model = D('Doctor');

				$now = time();
				
				//采用执行sql语句 非 save方法的原因的 避免调用_before_update() 之类方法
				$sql = "UPDATE zxznz_doctor SET is_top={$now} WHERE id={$id}";

				if( $model->execute($sql) !== FALSE )
				{
					echo json_encode(array(
						'result'	=>	TRUE,
						));
				}
				else
				{
					echo json_decode(array(
						'result'	=>	FALSE,
						));
				}
			}			
		}
		else
		{
			echo json_encode(array(
						'result'	=>	"您好 ！！请注意素质。",
						));
		}
	}
}