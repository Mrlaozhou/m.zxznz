<?php 
class Doctor extends Base
{
	public function index()
	{
		/*需求介绍*/// 提取符合的所有信息http://www.mzxznz.cn/api.php?u=a3JxYXZebiZlYmdwYnFeeg%3D%3D
		$doctor = M('doctor');
		$pagesize = 8;
		//接受参数
		$page = P('page') ? P('page') : 1;
		$start = ($page-1)*$pagesize;
		
		$sql = "SELECT d.id,d.name,d.picture,(h.name)hos_name FROM
					zxznz_doctor AS d 
					LEFT JOIN zxznz_hospital AS h 
					ON d.hos_id = h.id 
					WHERE h.is_show = '1' 
					ORDER BY d.id DESC 
					LIMIT ".$start.",".$pagesize;
		$data = $doctor->All($sql);
		//echo $sql;
		//dump($sql);
		echoJson(array('status'=>TRUE,'doctor'=>$data));
	}
	public function detial()
	{
		/*需求介绍*///提取单条 http://www.mzxznz.cn/api.php?u=eW52Z3JxXm4mZWJncGJxXno%3D
		$id = P('id');
		// $id = 100;
		if( !$id )
			echoJson(array('status'=>FALSE));

		$doctor = M('doctor');
		$sql = "SELECT d.id,d.name,d.title,d.edu,d.sex,d.name,d.picture,d.duty,d.good,d.intro,d.pass,d.start,(h.name)hos_name,(h.intro)hos_intro FROM 
					zxznz_doctor AS d 
					LEFT JOIN zxznz_hospital AS h 
					ON d.hos_id = h.id  
					WHERE h.is_show = '1' 
					AND d.id = {$id} ";
		$info = $doctor->One($sql);
		$info['intro'] = htmlspecialchars_decode($info['intro']);
		$info['hos_intro'] = htmlspecialchars_decode($info['hos_intro']);
		
		if( $info )
			echoJson(array('status'=>TRUE,'info'=>$info));			
		echoJson(array('status'=>FALSE));

	}
}