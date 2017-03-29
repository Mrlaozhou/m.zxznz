<?php 

class Index extends Base
{
	public function all()
	{
		/*需求介绍*///医生 12条 医院 9条 http://www.mzxznz.cn/api.php?u=eXluXm4ma3JxYXZeeg%3D%3D
		$doctor = M('doctor');

		$sql = "SELECT d.id,d.name,d.picture,(h.name)hos_name FROM 
					zxznz_doctor d 
					LEFT JOIN zxznz_hospital AS h 
					ON d.hos_id=h.id 
					WHERE ( h.is_show = '1' ) 
					ORDER BY d.id desc 
					LIMIT 12";
		$doctors = $doctor->All($sql);

		$hospital = M('Hospital');
		$sql = "SELECT id,name,logo FROM
					 zxznz_hospital 
					 WHERE is_show = '1' 
					 ORDER BY id DESC
					 LIMIT 9";
		$hospitals = $hospital->All($sql);

		$data['doctor'] = array_chunk($doctors,4);
		$data['hospital'] = array_chunk($hospitals,3);
		$data['status']	=	TRUE;
		//dump($data,2);
		echoJson($data);
	}
}