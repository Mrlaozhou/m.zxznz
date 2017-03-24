<?php 
class Active extends Base
{
	public function index()
	{
		/*需求介绍*/// 提取符合的所有信息 http://www.mzxznz.cn/api.php?u=a3JxYXZebiZyaXZncG5eeg%3D%3D
		$model = M('Active');

		$sql = "SELECT id,title,pic,intro,hospital FROM `zxznz_active` 
							WHERE `is_show` = '1'";
		$data = $model->All($sql);

		echoJson($data);
	}

	public function detial()
	{
		/*需求介绍*///提取单条 http://www.mzxznz.cn/api.php?u=eW52Z3JxXm4mZWJncGJxXno%3D
		$model = M('active');

		$id = G('id');
		if( $id )
			exit('冇ID.');
		$sql = "SELECT * FROM `zxznz_active` WHERE `id` = {$id}";

		$info = $model->One($sql);
		echoJson($info);
	}
}