<?php 
class User extends Allow
{
	public function person()
	{
		/*需求介绍*/// 提取个人用户信息 YWJmZXJjXm4mZXJmaF56
		$id = S('USER_ID');
		$model = M('User');
		$sql = "SELECT id,username,alias,create_time,last_time FROM 
								`zxznz_user` WHERE `id` = {$id}";
		$info = $model->One($sql);
		$info['last_time'] = date('Y-m-d H:i:s',$info['last_time']);
		$info['username'] = substr($info['username'],0,3).'****'.substr($info['username'],7);
		echoJson($info);
	}
}