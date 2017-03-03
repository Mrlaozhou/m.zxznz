<?php 
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller
{
	public function __construct()
	{
		//调用父类的构造方法
		parent::__construct();

		//判断是否登录
		if( !session('admin_id') ) 
		{
			$this->error('请先登录！',U('Login/login'));
		}
		else
		{
			//检测当前路由的 合法性
			if( md5(session('admin_name')) == '63a9f0ea7bb98050796b649e85481845' && md5(session('admin_id')) == 'c4ca4238a0b923820dcc509a6f75849b')
			{
				//如果是开发者，直接跳过
			}
			else
			{
				/************************ memcache 模式
				//获取权限列表
				//判断memcache中是否有值
				$mem = new \Memcache();
				$mem->connect('localhost',11211);
				if( $mem->get("pri_".session('admin_id')) )
				{
					$pri = $mem->get("pri_".session('admin_id'));
				}
				else
				{
					//实例化模型类
					$admin = D('Admin');
					
					$pri = $admin->chk_pri();
					$mem->set('pri_'.session('admin_id'),$pri,0,time()+3600);
				}
				*/
				
				/******无 memcache 模式*******/
				//实例化模型类
				$admin = D('Admin');
				$pri = $admin->chk_pri();
				/*************/

				//公共权限
				$public = array(
					'1'		=>	'Admin-Index-index',
					'2'		=>	'Admin-Index-top',
					'3'		=>	'Admin-Index-menu',
					'4'		=>	'Admin-Index-main',
					'5'		=>	'Admin-Index-showPerson',
					);

				//合并权限
				$PRI = array_merge($pri,$public);

				
				//当前路由
				$currentPath = MODULE_NAME.'-'.CONTROLLER_NAME.'-'.ACTION_NAME;


				//权限判断
				if( !in_array($currentPath,$PRI) )
				{
					//没有权限
					$this->error('无权访问！','',1);
				}
			}
		}
	}
}


