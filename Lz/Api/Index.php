<?php 

class Index extends Base
{
	public function all()
	{
		/*需求介绍*///医生 12条 医院 9条
		$doctor = M('doctor');

		$sql = "SELECT d.id,d.name,d.picture,(h.name)hos_name FROM 
					zxznz_doctor d 
					LEFT JOIN zxznz_hospital AS h 
					ON d.hos_id=h.id 
					WHERE ( d.is_show = '是' ) 
					ORDER BY d.id desc 
					LIMIT 8";
		$data['doctor'] = $doctor->All($sql);

		$hospital = M('Hospital');
		$sql = "SELECT id,name,logo FROM
					 zxznz_hospital 
					 WHERE is_show = '1' 
					 ORDER BY id DESC
					 LIMIT 9";
		$data['hospital'] = $hospital->All($sql);
		$data['status']	=	TRUE;
		
		echoJson($data);
	}
}