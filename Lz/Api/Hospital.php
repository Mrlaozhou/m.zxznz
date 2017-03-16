<?php
class Hospital extends Base
{
	public function index()
	{
		$h = M('hospital');
		$sql = "SELECT * FROM zxznz_hospital";
		$data = $h->All($sql);
		echo json_encode($data);
	}
}