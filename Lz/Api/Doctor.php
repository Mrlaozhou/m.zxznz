<?php 
class Doctor extends Base
{
	public function index()
	{
		$doctor = M('doctor');
		$sql = "DESC zxznz_doctor";
		dump($doctor->All($sql));
	}

}