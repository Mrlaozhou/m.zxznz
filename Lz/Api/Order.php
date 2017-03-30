<?php 

class Order extends Allow
{
	public function self()
	{
		/*需求介绍*///提取已支付订单 c3lyZl5uJmVycWViXno%3D
		$model = M('Order');
		$user_id = S('USER_ID');
		$sql = "SELECT o.id,o.status,o.code,o.active_id,o.create_time,o.need_pay,o.true_pay,o.count,a.title,a.pic,a.intro,a.hospital FROM 
						`zxznz_order` AS o 
						LEFT JOIN `zxznz_active` AS a ON a.id = o.active_id 
						LEFT JOIN `zxznz_user` AS u ON u.id = o.user_id 
						WHERE o.user_id = {$user_id}";
		$data = $model->All($sql);
		$result = array();
		foreach( $data as $k => $v )
		{
			if( $v['status'] == '2' )
				$result['yes'] = $v;
			elseif( $v['status'] == '1' )
				$result['no'] = $v;
			unset($data[$k]);
		}
		echoJson($result);
	}

}