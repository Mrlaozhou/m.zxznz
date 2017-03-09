<?php 
namespace Home\Controller;
use Think\Controller;

class ActiveController extends Controller
{
	public function lst()
	{
    	$this->assign(array(
    		'page_title' => '活动专场_智慧医美_整形指南针',
    		'page_desc'	 => PAGE_DESC,
    		));
		$this->display();
	}
	public function theme1()
	{
    	$this->assign(array(
    		'page_title' => '活动专场_智慧医美_整形指南针',
    		'page_desc'	 => PAGE_DESC,
    		));
		$this->display();
	}
	public function detial()
	{
    	$this->assign(array(
    		'page_title' => '活动详情页_智慧医美_整形指南针',
    		'page_desc'	 => PAGE_DESC,
    		));
		$this->display();
	}
	public function threey()
	{
    	$this->assign(array(
    		'page_title' => '活动详情页_智慧医美_整形指南针',
    		'page_desc'	 => PAGE_DESC,
    		));
		$this->display();
	}
	public function aquapeel()
	{
		$this->assign(array(
    		'page_title' => '活动详情页_智慧医美_整形指南针',
    		'page_desc'	 => PAGE_DESC,
    		));
		$this->display();
	}
}

