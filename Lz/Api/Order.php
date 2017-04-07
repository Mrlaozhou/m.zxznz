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

	public function despeak()
	{
		/*需求介绍*///预约页面  eG5yY2ZycV5uJmVycWViXno%3D 
		if( !P('activeId') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		//接收 id（活动）	
		$activeId 		= P('activeId');
		//sql
		$sql = "SELECT id,title,intro,pic,hospital,price FROM `zxznz_active`
							WHERE id = {$activeId} 
							LIMIT 1";
		$model = M('Active');
		$info = $model->One($sql);
		// dump($activeId);
		if( $info )
			echoJson(array('status'=>TRUE,'info'=>$info));
		echoJson(array('status'=>FALSE,'info'=>'006'));
	}

	public function create()
	{
		/*需求介绍*///订单生成  cmducmVwXm4mZXJxZWJeeg%3D%3D 
		if( !P('activeId') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		if( !P('count') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		//接收 id（活动）	
		$data['activeId'] 		= P('activeId');
		//获取活动信息
		$sql = "SELECT price FROM `zxznz_active` WHERE id = {$data['activeId']}";
		$info = M('active')->One($sql);
		$data['price'] = $info['price'];

		//解析用户id
		$data['userId']			= S('USER_ID');
		//订单创建时间
		$data['create_time'] 	= time();
		//数量
		$data['count'] 			= P('count');
		//需支付
		$data['need_pay']		= $data['count'] * $data['price'];
		//来源渠道
		$data['from'] 			= '2';
		//生成订单编号   订单编码规则：base64_encode(user_id+active_id+time+count+from);
		$code 	   				= base64_encode(trim($data['userId']).'-'.
                                                trim($data['activeId']).'-'.
                                                trim($data['create_time']).'-'.
                                                trim($data['count']).'-'.
                                                trim($data['need_pay']).'-'.
                                                trim($data['from']));
		//储存订单信息
		$sql = "INSERT INTO `zxznz_order` SET 
							`code`		= '{$code}',
							`from`		= '2',
							`status` 	= '1',
							`user_id` 	= {$data['userId']}, 
							`active_id` = {$data['activeId']}, 
							`need_pay`  = {$data['need_pay']}, 
							`count` 	= {$data['count']}, 
							`price` 	= {$data['price']}, 
							`create_time` = {$data['create_time']}";
		$order = M('order');
		// dump($order);
		$result = $order->exec($sql);
		$newId = $order->lastInsertId();
		if( $result !== FALSE )
			echoJson(array('status'=>TRUE,'orderId'=>$newId));
		echoJson(array('status'=>FALSE,'info'=>'444'));
	}

	public function orderInfo()
	{
		/*需求介绍*///获取当前订单信息  YnNhVmVycWViXm4mZXJxZWJeeg%3D%3D 
		if( !P('orderId') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		$orderId = P('orderId');
		$sql = "SELECT o.id,o.code,o.price,o.count,o.need_pay,a.title,a.intro,a.hospital,a.pic
							FROM `zxznz_order` AS o
							LEFT JOIN `zxznz_active` AS a ON o.active_id = a.id
							WHERE o.id = {$orderId} 
							LIMIT 1";
		$info = M('order')->One($sql);
		if( !$info )
			echoJosn(array('status'=>FALSE,'info'=>'006')); 
		$info['title'] = htmlspecialchars_decode($info['title']);
		$info['intro'] = htmlspecialchars_decode($info['intro']);
		echoJson(array('status'=>TRUE,'info'=>$info));
	}

	public function pay()
	{
		/*需求介绍*///订单支付  bG5jXm4mZXJxZWJeeg%3D%3D 
		if( !P('pay_type') || !P('orderId') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		dump(P());
		switch (P('pay_type')) 
		{
			case '1':
				# 支付宝
				$this->aliPay();
				break;
			case '2':
				# 微信
				$this->wxPay();
				break;
			default:
				break;
		}
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
		//接收参数
		if( $receive = P() )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		define('ALI',VENDOR_PATH.'Alipay'.DS);
		$config = load(ALI.'config.php');
		load(ALI.'AlipayTradeService.php');

		$alipaySevice = new AlipayTradeService($config); 
		$alipaySevice->writeLog(var_export($receive,true));
		$result = $alipaySevice->check($receive);

		if( $result )
		{

		}
	}

	public function wxPay()
	{
		/*需求介绍*///微信支付接口 bG5Da2pebiZlcnFlYl56
		
		//定义路径常量
		define('WX',VENDOR_PATH.'Wxpay'.DS);
		//加载微信三方插件
		// $list = Vendor('wxpay');
		// $input = new \WxPayUnifiedOrder();
		// $input->SetBody('上海纽珀');
		// $input->SetAttach();
		// $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
		// $input->SetTotal_fee(*100);
		// $input->SetTime_start(date("YmdHis"));
		// $input->SetTime_expire(date("YmdHis", time() + 600));
		// $input->SetGoods_tag();
		// $input->SetNotify_url("http://m.zxznz.cn/index.php?u=Z3JUa2pebiZlcnFlYl56");
		// $input->SetTrade_type("MWEB");
		// $input->SetProduct_id();
		// dump($input);
	}
	public function wxGet()
	{
		/*需求介绍*///微信回调接口  Z3JUa2pebiZlcnFlYl56
	}
}

