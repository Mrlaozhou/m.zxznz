<?php 

class Publish extends Base
{
	public function index()
	{
		/*需求介绍*///提取符合的所有信息 a3JxYXZebiZ1ZnZ5b2hDXno%3D
		$model = M('Publish');

		$sql = "SELECT `id`,`title`,`begin`,`action` 
									FROM `zxznz_publish` 
									WHERE `is_show` = 1 
									ORDER BY `begin` DESC";


		$data = $model->all($sql);

		echoJson($data);
	}
}