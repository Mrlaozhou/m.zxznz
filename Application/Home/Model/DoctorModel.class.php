<?php 
namespace Home\Model;

class DoctorModel
{
	public function search()
	{
		$model = D('Admin/Doctor');
		/************分页*********/
		//每页显现数
		$pagesize = 6;

		//总数
		$count = $model->alias('d')
					   ->join('LEFT JOIN zxznz_hospital AS h ON d.hos_id=h.id')
					   ->where(array(
					  	'd.is_show'	=>	array('eq','是'),
					  	'h.is_show'	=>	array('eq','1'),
					  	))
					   ->count();

		$page = new \Think\Page($count,$pagesize);

		$page -> setConfig('prev','< PREV');
		$page -> setConfig('next','NEXT >');

		$data['page'] = $page->show();

		$data['data'] = $model->alias('d')
							  ->join('LEFT JOIN zxznz_hospital AS h ON d.hos_id=h.id')
							  ->field('d.id,d.name,d.hos_id,d.name,d.picture,d.is_show,d.intro,h.name as hos_name')
							  ->where(array(
							  	'd.is_show'	=>	array('eq','是'),
								'h.is_show'	=>	array('eq','1'),
							  	))
							  ->limit($page->firstRow.','.$page->listRows)
							  ->order('id')
							  ->select();

		return array(
			'page'	=>	$data['page'],
			'data'	=>	$data['data'],			/*array_chunk($data['data'],3)*/
			);
	}
}