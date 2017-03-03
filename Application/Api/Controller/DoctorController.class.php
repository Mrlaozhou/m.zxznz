<?php 
namespace Api\Controller;
use Api\Controller\PhoneController;
// +----------------------------------------------------------------------
// | 移动端专家库页表页数据接口
// +----------------------------------------------------------------------
// | doctor list:	doctor all
// +----------------------------------------------------------------------
class DoctorController extends PhoneController
{
	public function index()
	{
		//接受参数
		$config = I('post.');
		$p = $config['page'] ? $config['page'] : 1;
		$pagesize = 8;
		$begin = ($p-1)*$pagesize;
		$model = M('Doctor');

		$doctor = $model->field('d.id,d.name,d.picture,(h.name)hos_name')
						->alias('d')
						->join('LEFT JOIN zxznz_hospital as h ON d.hos_id = h.id')
						->where(array(
							'h.is_show'	=>	array('eq','1'),
							'd.is_show'	=>	array('eq','是'),
							))
						->order('d.is_top desc')
						->limit($begin.','.$pagesize)
						->select();
		if( $doctor )
		{
			echo json_encode(array(
				'status'	=>	TRUE,
				'doctor'	=>	$doctor,
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
			$model = M('Doctor');

			$info = $model->field('d.id,d.name,d.title,d.edu,d.sex,d.duty,d.picture,d.pass,d.intro,d.start,d.good,(h.name)hos_name,(h.intro)hos_intro')
						  ->alias('d')
						  ->join('LEFT JOIN zxznz_hospital as h ON d.hos_id=h.id')
						  ->where(array(
						  	'd.id'	=>	array('eq',$config),
						  	))
						  ->limit(1)
						  ->select();

			if( $info )
			{
				$info = $info[0];
				$info['intro'] = htmlspecialchars_decode($info['intro']);
				$info['hos_intro'] = htmlspecialchars_decode($info['hos_intro']);
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