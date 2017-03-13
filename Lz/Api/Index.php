<?php 

class Index extends Base
{
	public function all()
	{
		$doctor = M('doctor');

		$sql = "SELECT d.id,d.name,d.picture,(h.name)hos_name FROM zxznz_doctor d LEFT JOIN zxznz_hospital AS h ON d.hos_id=h.id WHERE ( d.is_show = '是' ) ORDER BY d.id desc LIMIT 8";
		$data['doctor'] = $doctor->all($sql);

		jsonTo($data);
	}
}