<?php 
namespace Home\Controller;

class HreplyController
{
	public function ajaxHosReply()
	{
		//判断是否是ajax提交
		if( IS_AJAX )
		{
			//判断用户是否登录
			if( session('user_id') )
			{
				//实例化模型
				$model = D('Hreply');

				$config = I('post.');

				//处理参数数据
				$data['cmt_id']		=	 (int)$config['cmt_id'];
				$data['user_id']	=	(int)session('user_id'); 
				$data['user_name']	=	session('user_name'); 
				$data['content']	=	trim($config['content']);
				$data['hos_id']	=	(int)$config['hos_id'];

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
							//转变日期格式
							$line['time'] = date('Y/m/d H:i:s',$line['time']);
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
						"info"		=>	'回复内容不能为空！',
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
	public function vlogin()
	{
		// session('user_id',8);
		// session('user_name','周广升');

		dump(session('user_id'));
		dump(session('user_name'));
	}
}