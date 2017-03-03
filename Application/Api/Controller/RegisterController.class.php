<?php 
namespace Api\Controller;
use Api\Controller\PhoneController;
// +----------------------------------------------------------------------
// | 移动端注册数据接口
// +----------------------------------------------------------------------
// | detial:	checkPhone
// +----------------------------------------------------------------------
class RegisterController extends PhoneController
{
	public function checkExists()
	{
		//接受参数
		$config = I('post.');

		if( !empty( $config ) )
		{
			$phone = trim($config['phone']);
			if( $phone == (int)$phone )
			{
				/*验证手机号*/
				$model = M('User');
				
				$result = $model->field('username')
								->where(array(
									'username'	=>	array('eq',$phone),
									))
								->find();
				if( !empty($result) )
				{
					if( $result['username'] == $phone )
					{
						echo json_encode(array(
							'status'	=>	FALSE,
							'info'		=>	'003',		//此手机已注册
							));
					}
					else
					{
						echo json_encode(array(
							'status'	=>	FALSE,
							'info'		=>	'004',		//恶意攻击
							));							
					}
				}
				else
				{
					echo json_encode(array(
						'status'	=>	TRUE,
						'info'		=> 	null,
					));		
				}
			}
			else
			{
				echo json_encode(array(
					'status'	=>	FALSE,
					'info'		=>	'002',		//参数可能出错！
					));
			}		
		}
		else
		{
			echo json_encode(array(
				'status'	=>	FALSE,
				'info'		=>	'001',		//传参、接参出错！
				));
		}
	}
}