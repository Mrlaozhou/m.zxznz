<?php 
namespace Admin\Controller;

class HospitalController extends BaseController
{
	public function lst()
	{
		//实例化模型类
		$model = D('Hospital');

		//获取数据
		$data = $model->search();

		$this->assign(array(
			'_page_title'		=>	'医院列表',
			'_page_btn_link'	=>	U('add'),
			'_page_btn_name'	=>	'添加医院',
			'page'				=>	$data['page'],
			'data'				=>	$data['data'],
			));

		$this->display();
	}

	public function add()
	{
		//实例化模型类
		$model = D('Hospital');

		if( IS_POST )
		{
			if( $model->create( I('post.'),1 ) )
			{
				if( $model->add() )
				{
					$this->success('添加医院信息成功！',U('lst'));
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
			//实例化xml，获得省份信息
			$smp = simplexml_load_file(__PUBLIC__.'Area.xml');

			//获取医院分类信息
			$typeModel = D('Type');
			$types = $typeModel->field('id,type_name')
							  ->select();

			$this->assign(array(
				'_page_title'		=>	'添加医院',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'医院列表',

				'types'				=>	$types,
				'smp'				=>$smp,
				));
			$this->display();
		}
	}

	public function del()
	{
		//接收参数
		$id = I('get.id');
		//实例化对象
		$model = D('Hospital');

		if( $model->delete($id) !== FALSE )
		{	
			$this->success('删除医院信息成功！',U('lst'));
			exit;
		}
		else
		{
			$this->error($model->getError());
		}
	}

	public function edit()
	{
		//实例化模型类
		$model = D('Hospital');

		if( IS_POST )
		{

			//实例化模型类
			$model = D('Hospital');

			if($model->create(I('post.'),2))
			{
				if( $model->save() !== FALSE )
				{
					$this->success('修改信息成功！',U('lst'));
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
			//接收ID
			$id = I('get.id');

			//提取此条记录的信息
			$info = $model->field('id,name,tel,address,logo,is_show,intro,is_index,is_top')
						  ->find($id);
			//提取hos_img中的信息
			$HImodel = M('Hos_img');
			$imgs = $HImodel->field('id,path')->where(array('hos_id'=>array('eq',$id)))->select();

			//实例化xml，获得省份信息
			$smp = simplexml_load_file(__PUBLIC__.'Area.xml');

			//获取医院所有分类信息
			$typeModel = D('Type');
			$types = $typeModel->field('id,type_name')
							  ->select();

			//当前医院的分类信息
			$sql = "SELECT GROUP_CONCAT(type_id)ids FROM zxznz_hos_type WHERE hos_id=".$id;
			$typeIds = $typeModel->query($sql);

			$typeIds = explode(',',$typeIds['0']['ids']);
			
			$this->assign(array(
				'_page_title'		=>	'修改医院信息',
				'_page_btn_link'	=>	U('lst'),
				'_page_btn_name'	=>	'医院列表',

				'info'				=>	$info,
				'address'			=>  explode('-',$info['address']), 
				'smp'				=>	$smp,
				'imgs'				=>	$imgs,
				'types'				=>	$types,
				'typeIds'			=>	$typeIds,
				));

			$this->display();
		}
	}

	public function ajaxGetCitys()
	{
		//接收
		$province = I('get.province');
		$province = urldecode( $province );
		//实例化 simpleXML 
		$smp = simplexml_load_file(__PUBLIC__.'Area.xml');
		//查找当前省份下的所有城市
		$path = "/cities/province[@name='".$province."']/item";
		$city = $smp->xpath($path);

		//处理数据
		$result = array();
		foreach($city as $k => $v)
		{
			//
			$result[] = (string)$v;
		}
		echo json_encode($result);	
	}

	public function ajaxDelPic()
	{
		//接收Id
		$id = I('get.id');
		//实例化模型
		$HImodel = M('Hos_img');

		//查出数据，删除磁盘信息
		$info = $HImodel->field('path')->find($id);

		@unlink(__UPLOADS__.$info['path']);

		if($HImodel->delete($id))
		{
			echo json_encode(array('result'=>1));
		}
		else
		{
			echo json_encode(array('result'=>0));
		}
	}

	public function ajaxComment()
	{
		//接收医院Id
		$id = I('get.id');

		//接收分数
		$score = I('get.score');

		//实例化模型
		$model = D('Hospital');

		if( $score )
		{
			//评分增加
			$model->where(array(
				'id'		=>	array('eq',$id),
				))->setInc('score_total',(int)$score);

			//评分人数  +1 		
			$model->where(array(
				'id'		=>	array('eq',$id),
				))->setInc('score_number');
 		}
	}

	public function ajaxRefreshHosTop()
	{
		if( IS_AJAX )
		{
			$id = I('get.id');
			if( $id )
			{
				//实例化hospital model 
				$model = D('Hospital');

				$now = time();
				
				//采用执行sql语句 非 save方法的原因的 避免调用_before_update() 之类方法
				$sql = "UPDATE zxznz_hospital SET is_top={$now} WHERE id={$id}";

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
