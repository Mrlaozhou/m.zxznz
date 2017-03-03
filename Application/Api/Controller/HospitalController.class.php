<?php 
namespace Api\Controller;
use Api\Controller\PhoneController;
class HospitalController extends PhoneController
{
	public function index()
	{
		//接受参数
		$config = I('post.');
		$p = $config['page'] ? $config['page'] : 1;
		//每页显示
		$pagesize = 8;
		$begin = ($p-1)*$pagesize;
		$model = M('Hospital');

		$hospital = $model->field('id,name,logo')
						->where(array(
							'is_show'	=>	array('eq','1'),
							))
						->order('is_top desc')
						->limit($begin.','.$pagesize)
						->select();
		if( $hospital )
		{
			echo json_encode(array(
				'status'	=>	TRUE,
				'hospital'	=>	$hospital,
				));
		}
		else
		{
			echo json_encode(array(
				'status'	=>	FALSE,
				'info'		=>	'006',
				));
		}
	}

	public function detial()
	{
		//接受参数
		$config = I('post.id');

		if( $config )
		{
			$model = M('Hospital');

			$info = $model->field('id,name,tel,address,logo,intro,like')
						  ->find($config);
			if( $info )
			{
				$info['intro'] = htmlspecialchars_decode($info['intro']);
				echo json_encode(array(
					'status'	=>	TRUE,
					'info'		=>	$info,		
					));
			}
			else
			{
				echo json_encode(array(
					'status'	=>	FALSE,
					'info'		=>	'006',
					));
			}
		}
		else
		{
			echo json_encode(array(
				'status'	=>	FALSE,
				'info'		=>	'001',
				));
		}
	}
}