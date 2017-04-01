<?php 

class Order extends Allow
{
	public function self()
	{
		/*需求介绍*///提取个人订单 c3lyZl5uJmVycWViXno%3D
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
			$v['intro'] = htmlspecialchars_decode($v['intro']);
			if( $v['status'] == '2' )
				$result['yes'][] = $v;
			elseif( $v['status'] == '1' )
				$result['no'][] = $v;
			unset($data[$k]);
		}
		$result['status'] = TRUE;
		//dump($result,2);
		echoJson($result);
	}

	public function publicPay()
	{
		dump(Vendor('wxpay'));

	}

	public function aliPay()
	{
		/*需求介绍*///阿里支付接口 bG5DdnluXm4mZXJxZWJeeg%3D%3D
		
		if (!empty($_POST['WIDout_trade_no']) && trim($_POST['WIDout_trade_no'])!="")
		{
			//定义路径常量
			define('ALI',VENDOR_PATH.'Alipay'.DS);
			define('AOP_SDK_WORK_DIR',ALI.'tmp/');

			//手动加载类
			load(ALI.'AlipayTradeService.php');
			load(ALI.'AlipayTradeWapPayContentBuilder.php');
			$config = load(ALI.'config.php');
			
		    //商户订单号，商户网站订单系统中唯一订单号，必填
		    $out_trade_no = $_POST['WIDout_trade_no'];

		    //订单名称，必填
		    $subject = $_POST['WIDsubject'];

		    //付款金额，必填
		    $total_amount = $_POST['WIDtotal_amount'];

		    //商品描述，可空
		    $body = $_POST['WIDbody'];

		    //超时时间
		    $timeout_express="1m";

		    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
		    $payRequestBuilder->setBody($body);
		    $payRequestBuilder->setSubject($subject);
		    $payRequestBuilder->setOutTradeNo($out_trade_no);
		    $payRequestBuilder->setTotalAmount($total_amount);
		    $payRequestBuilder->setTimeExpress($timeout_express);

		    $payResponse = new AlipayTradeService($config);
		    $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

		    return ;
		}
		//没有传参
		echoJson(array('status'=>FALSE,'info'=>'001'));
	}

	public function aliGet()
	{
		/*需求介绍*///阿里回调接口 Z3JUdnluXm4mZXJxZWJeeg%3D%3D
	}
}
