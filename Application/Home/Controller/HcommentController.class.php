<?php 
namespace Home\Controller;

class HcommentController
{
	public function ajaxHosComment()
	{
		//判断是否是ajax提交
		if( IS_AJAX )
		{

			//判断用户是否登录
			if( session('user_id') )
			{
				//实例化模型
				$model = D('Hcomment');

				$config = I('post.');

				//处理参数数据
				$data['hos_id']		=	 (int)$config['hos_id'];
				$data['user_id']	=	(int)session('user_id'); 
				$data['user_name']	=	session('user_name'); 
				$data['content']	=	trim($config['content']);

				//再次判断 不能为空
				if( $data['content'] )
				{
					if( $model->create( $data,1 ) )
					{
						if( $id = $model->add() )
						{
							//取出这条数据
							$line = $model->field('id,user_name,content,time')
										  ->find($id);
							$line['time'] = date('Y/m/d H:i',$line['time']);
							echo json_encode(array(
								'result'	=>	TRUE,
								'info'		=>	$line,
								));
						}
						else
						{
							echo json_encode(array(
								'result'	=>	FALSE,
								'info'		=>	$model->getError(),
								));
						}
					}
					else
					{
						echo json_encode(array(
							'result'	=>	FALSE,
							'info'		=>	$model->getError(),
							));
					}					
				}
				else
				{
					echo json_encode(array(
						'result'	=>	FALSE,
						"info"		=>	'评论内容不能为空！',
						));
				}
			}
			else 
			{
				echo json_encode(array(
					'result'	=>	FALSE,
					"info"		=>	'请先登录！',
					));
			}	
		}
		else
		{
			echo json_encode(array(
				'result'	=>	FALSE,
				'info'		=>  "你好 请注意素质！",
				));
		}
	}

	public function test()
	{
		$model = D('Hcomment');
		/*模拟登录*/
		// session('user_id',1);
		// session('user_name','laozhou');
		

		//测试登录
		echo session('user_name');
		dump(session('user_id'));
	}
}