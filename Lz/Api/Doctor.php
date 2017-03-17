<?php 
class Doctor extends Base
{
	public function index()
	{
		/*需求介绍*///提取符合的所有信息
		$doctor = M('doctor');
		$sql = "SELECT * FROM
					zxznz_doctor AS d 
					LEFT JOIN zxznz_hospital AS h 
					ON d.hos_id = h.id
					WHERE d.is_show = '是' 
					AND h.is_show = '1'
					ORDER BY d.id DESC
					";
		$data = $doctor->All($sql);
		echoJson($data);
	}
	public function detial()
	{
		/*需求介绍*///提取单条
		$id = G('id');
		if( $id )
		{
			$doctor = M('doctor');
			$sql = "SELECT d.id,d.name,d.title,d.edu,d.sex,d.name,d.picture,d.duty,d.good,d.intro,d.pass,d.start,(h.name)hos_name,h.intro FROM 
						zxznz_doctor AS d 
						LEFT JOIN zxznz_hospital AS h 
						ON d.hos_id = h.id 
						WHERE d.is_show = '是' 
						AND h.is_show = '1' 
						AND d.id = {$id} ";
			$info = $doctor->One($sql);
			if( $info )
			{
				echoJson($info);			
			}
			else
			{
				echoJson(array('status'=>FALSE));
			}
		}
		else
		{
			echoJson(array('result'=>FALSE));
		}
	}
}