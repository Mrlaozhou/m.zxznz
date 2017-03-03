<?php 
namespace Home\Model;

class HospitalModel
{
	public function search()
	{
		$model = D('Admin/Hospital');

		/************分页*********/
		//每页显现数
		$pagesize = 6;

		//总数
		$count = $model->where(array(
					  	'is_show'	=>	array('eq','1'),
					  	))
					   ->count();

		$page = new \Think\Page($count,$pagesize);

		$page -> setConfig('prev','< PREV');
		$page -> setConfig('next','NEXT >');

		$data['page'] = $page->show();

		$data['data'] = $model->field('id,name,logo,is_show')
							  ->where(array(
							  	'is_show'	=>	array('eq','1'),
							  	))
							  ->limit($page->firstRow.','.$page->listRows)
							  ->order('is_top desc')
							  ->select();
		return $data;
	}
}