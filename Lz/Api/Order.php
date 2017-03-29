<?php 

class Order extends Allow
{
	public function yes()
	{
		/*需求介绍*///提取已支付订单 ZnJsXm4mZXJxZWJeeg%3D%3D
		$model = M('Order');
		$user_id = S('USER_ID');
		$sql = "SELECT o.id,o.status,o.code,o.active_id,o.create_time,o.need_pay,o.true_pay,o.count,a.title,a.pic,a.intro,a.hospital FROM 
						`zxznz_order` AS o 
						LEFT JOIN `zxznz_active` AS a ON a.id = o.active_id 
						LEFT JOIN `zxznz_user` AS u ON u.id = o.user_id 
						WHERE o.user_id = {$user_id} 
						AND o.status = '2'";
		$data = $model->All($sql);
		echoJson($data);
	}
	public function no()
	{
		/*需求介绍*///提取未支付订单 YmFebiZlcnFlYl56
		$model = M('Order');
		$user_id = S('USER_ID');
		$sql = "SELECT o.id,o.status,o.code,o.active_id,o.create_time,o.need_pay,o.true_pay,o.count,a.title,a.pic,a.intro,a.hospital FROM 
						`zxznz_order` AS o 
						LEFT JOIN `zxznz_active` AS a ON a.id = o.active_id 
						LEFT JOIN `zxznz_user` AS u ON u.id = o.user_id 
						WHERE o.user_id = {$user_id} 
						AND o.status = '1'";
		$data = $model->All($sql);
		echoJson($data);
	}
}