<?php 
namespace Admin\Controller;
use Think\Controller;

class IndexController extends BaseController
{
	public function index()
	{
		$this->display();
	}
	public function top()
	{
		$this->display();
	}	
	public function menu()
	{
		//实例化 Privilege 模型类
		$pri = D('Privilege');

		//获取权限列表
		$priData = $pri -> select();

		//转化为 树型
		$priData = getTree($priData);

		$this->assign(array(
			'priData'		=>	$priData,
			));
		$this->display();
	}	
	public function main()
	{
		$this->display();
	}
	public function showPerson()
	{
		$this->display();
	}
}