<?php 
namespace Home\Controller;
use Think\Controller;


class SponsorController extends Controller
{
	public function index()
	{
		$this->assign(array(
			'page_title'	=>	'战略合作_智慧医美_整形指南针',
			'page_desc'	=>	'e折整形 全国抢购',
			));
		$this->display();
	}
	public function add()
	{
		
	}
}