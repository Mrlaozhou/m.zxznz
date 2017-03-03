<?php 
namespace Home\Controller;
use Think\Controller;

class HospitalController extends Controller{
	public function index()
	{
		//
		$model = D('Home/Hospital');

		$data = $model->search();

		$this->assign(array(
			'page_title'	=>	'医院专区_智慧医美_整形指南针',
			'page_desc'		=>	'e折整形 全国抢购',

			'data'			=>	$data,
			));
		$this->display();
	}
	public function detial()
	{
		$hos_id = I( 'get.hos_id' );
		
		$model = D('Admin/Hospital');
		$info = $model->field('id,name,logo,intro,like')
					  ->find($hos_id);

		/**********评论信息 start************/
		//提取评论信息
		$Hcmodel = D('Hcomment');
		$pl = $Hcmodel->field('id,user_name,content,time')
						   ->where(array(
						   	'hos_id'	=>	array('eq',$hos_id),
						   	))
						   ->order('time desc')
						   ->select();
		//提取回复信息
		$Hrmodel = D('Hreply');

		$hf = $Hrmodel->field('id,cmt_id,user_name,content,time')
					  ->where(array(
						  'hos_id'	=>	array('eq',$hos_id),
						  ))
					  ->order('time desc')
					  ->select();

		//数据处理 
		foreach($pl as $k => $v)   //循环回复
		{
			foreach($hf as $kk => $vv)   //循环评论
			{
				if( $v['id'] == $vv['cmt_id'] )  //如果属于此条评论的回复 提取
				{
					$pl[$k]['hf'][] = $vv;
					unset($hf[$kk]);
				}
			}
		}
		// dump($pl);
		// exit;
		/**********评论信息 end************/
		$this->assign(array(
			'page_title'	=>	$info['name'].'_医院详情页_智慧医美_整形指南针',
			'page_desc'		=>	'e折整形 全国抢购',
			'page_key'		=>	$info['name'],

			'info'			=>	$info,
			'pl'			=>	$pl,
			));
		$this->display();
	}
	public function ajaxLikeHos()
	{
		if( IS_AJAX )
		{
			if( session('user_id') )
			{
				$id = I("get.id");
				if( $id )
				{
					$model = D('Admin/Hospital');

					$info = $model->field('like')->find($id);
					$like = (int)$info['like']+1;
					$sql = "UPDATE zxznz_hospital SET `like`='{$like}' WHERE `id`={$id}";

					if( $model->execute($sql) !== FALSE )
					{
						echo json_encode(array(
							'result'	=>	TRUE,
							'like'		=>	$like,
							));
					}
					else
					{
						echo json_encode(array(
							'result'	=>	FALSE,
							));
					}
				}
				else
				{
					echo json_encode(array(
						'result'	=>	FALSE,
						));
				}
			}
			else
			{
				echo json_encode(array(
					'result'	=>	FALSE,
					'info'		=>	'请先登录！',
					));
			}
		}
		else
		{
			echo json_encode(array(
				'result'	=>	FALSE,
				'info'		=>	'你好  请注意素质！',
				));
		}
	}
}
