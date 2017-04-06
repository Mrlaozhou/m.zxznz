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
		if( $info )
			echoJson(array('status'=>TRUE,'info'=>$info));
		echoJson(array('status'=>FALSE,'info'=>'006'));
	}

	public function create()
	{
		/*需求介绍*///订单生成  cmducmVwXm4mZXJxZWJeeg%3D%3D 
		if( !P('activeId') )
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
		$result = M('order')->exec($sql);
		dump($sql);
		if( $result !== FALSE )
			echoJson(array('status'=>TRUE));
		echoJson(array('status'=>FALSE,'info'=>'444'));
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

	}
	public function wxGet()
	{}
}

/*

| zxznz_order | CREATE TABLE `zxznz_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(60) NOT NULL DEFAULT '' COMMENT '订单编号',
  `from` enum('3','2','1') NOT NULL COMMENT '1.PC端2.手机端3.其他',
  `status` enum('7','2','1','0') NOT NULL DEFAULT '0' COMMENT '0.无状态1.未支付挂起2.已支付7.已取消',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `active_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动ID',
  `create_time` varchar(30) NOT NULL DEFAULT '' COMMENT '订单生成时间',
  `cancel_time` varchar(30) NOT NULL DEFAULT '' COMMENT '订单取消时间',
  `pay_time` varchar(30) NOT NULL DEFAULT '' COMMENT '客户付款时间',
  `need_pay` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '此订单的金额',
  `true_pay` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '客户实付款',
  `pay_type` enum('4','3','2','1','0') NOT NULL DEFAULT '0' COMMENT '0.无状态1.支付宝2.微信3.现金4.其他',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单产品数量',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品单价',
  `ali_no` varchar(28) NOT NULL DEFAULT '' COMMENT '支付宝交易编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 |

 */