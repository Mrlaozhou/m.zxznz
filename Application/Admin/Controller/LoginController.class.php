<?php 
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller
{
	public function login()
	{
		if( IS_POST )
		{
			//实例化验证码类
			$verify = new \Think\Verify();
			if( $verify->check(I('post.chk_code'),1) )
			{
				//实例化Admin模型类
				$admin = D('Admin');

				//调用验证方法
				$result = $admin->chk_login(I('post.'));
				switch ($result)
				{
					case 1:
						$this->success('登录成功！',U('Index/index'));
						break;
					case 0:
						$this->error('密码错误！');
						break;
					case -7:
						$this->error('账号不存在！');
				}
			}
			else
			{
				$this->error('验证码错误');
			}
		}
		else
		{
			$this->display();
		}
	}
	public function login_verify()
	{
		//实例化验证码模型
		$config = array(
        'fontSize'  =>  14,              // 验证码字体大小(px)
        'useCurve'  =>  false,            // 是否画混淆曲线
        'useNoise'  =>  false,            // 是否添加杂点	
        'imageH'    =>  30,               // 验证码图片高度
        'imageW'    =>  100,               // 验证码图片宽度
        'length'    =>  1,               // 验证码位数
 			);
		$verify = new \Think\Verify($config);

		//调用显示验证码图片
		$verify->entry(1);
	}
	public function logout()
	{
		if ( session('admin_id') )
		{
			flushMemcache();

			//清空session
			session(null);

			$this->success('退出登陆成功！',U('Login/login'),2);
			exit;
		}
	}
}
