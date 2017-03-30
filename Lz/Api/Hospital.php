<?php
class Hospital extends Base
{
	public function index()
	{
		/*需求介绍*///提取符合的所有信息 http://www.mzxznz.cn/api.php?u=a3JxYXZebiZ5bmd2Y2ZidV56
		$hospital = M('hospital');
		$pagesize = 8;
		//接受参数
		$page = P('page') ? P('page') : 1;
		$start = ($page-1)*$pagesize;

		$sql = "SELECT id,name,logo FROM zxznz_hospital 
						WHERE `is_show` = '1' 
						ORDER BY `id` DESC
						LIMIT {$start},{$pagesize}";
		$data = $hospital->All($sql);
		//dump($data,2);
		echoJson(array('status'=>TRUE,'hospital'=>$data));
	}
	public function detial()
	{
		/*需求介绍*///提取单条 http://www.mzxznz.cn/api.php?u=eW52Z3JxXm4meW5ndmNmYnVeeg%3D%3D

		$model = M('hospital');
		$id = P('id');
		if( !$id )
			exit('冇ID.');
		$sql = "SELECT * FROM `zxznz_hospital`
							 WHERE `id` = {$id}";
		$info = $model->One($sql);
		$info['intro'] = htmlspecialchars_decode($info['intro']);
		//dump($info,2);
		echoJson(array('status'=>TRUE,'info'=>$info));
	}
}