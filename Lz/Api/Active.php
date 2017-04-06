<?php 
class Active extends Base
{
	public function index()
	{
		/*需求介绍*/// 提取符合的所有信息 a3JxYXZebiZyaXZncG5eeg%3D%3D
		$model = M('Active');

		$sql = "SELECT id,title,pic,intro,hospital,start_time FROM `zxznz_active` 
							WHERE `is_show` = '1'";
		$data = $model->All($sql);
		// dump($data);
		dump($data,2);
		if( $data )
			echoJson(array('status'=>TRUE,'data'=>$data));
		echoJson(array('status'=>FALSE));
	}

	public function detial()
	{
		/*需求介绍*///提取单条 http://www.mzxznz.cn/api.php?u=eW52Z3JxXm4mcml2Z3BuXno%3D
		$model = M('active');

		$id = P('id');
		if( !$id )
			exit('冇ID.');
		$sql = "SELECT * FROM `zxznz_active` WHERE `id` = {$id}";

		$info = $model->One($sql);
		if( $info )
			echoJson(array('status'=>TRUE,'info'=>$info));
		echoJson(array('status'=>FALSE));
	}
}