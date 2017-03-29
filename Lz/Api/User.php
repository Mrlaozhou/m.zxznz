<?php 
class User extends Allow
{
	public function person()
	{
		/*需求介绍*/// 提取个人用户信息 
		$id = S('USER_ID');
		$model = M('User');
		$sql = "SELECT id,username,alias,create_time,last_time FROM 
								`zxznz_user` WHERE `id` = {$id}";
		$info = $model->One($sql);
		echoJson($info);
	}
}