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
		$info = self::getInfo($orderId);
		if( !$info )
			echoJosn(array('status'=>FALSE,'info'=>'006')); 
		echoJson(array('status'=>TRUE,'info'=>$info));
	}

	public function pay()
	{
		/*需求介绍*///订单支付  bG5jXm4mZXJxZWJeeg%3D%3D 
		
		if( !P('pay_type') || !P('orderId') )
			echoJson(array('status'=>FALSE,'info'=>'001'));
		//取出订单信息
		$orderId = P('orderId');
		$sql = "SELECT o.id,o.need_pay,o.code,o.active_id,a.title FROM `zxznz_order` AS o 
								LEFT JOIN `zxznz_active` AS a 
								ON a.id = o.active_id 
								WHERE o.id = {$orderId} 
								LIMIT 1";
		$info = M('order')->One($sql);
		
		if( !$info )
			echoJson(array('status'=>FALSE,'info'=>'006'));
		// dump(P('pay_type'));
		switch (P('pay_type')) 
		{
			case '1':
				# 支付宝
				$this->aliPay($info);
				break;
			case '2':
				# 微信
				//$this->wxPay($info);
				//$this->wxJsPay($info);
				echo '敬请期待~';
				break;
			default:
				break;
		}
	}

	public function aliPay($info=null)
	{
		header("Content-Type:text/html;charset=utf-8");
		/*需求介绍*///阿里支付接口 bG5DdnluXm4mZXJxZWJeeg%3D%3D
		//定义路径常量
		define('ALI',VENDOR_PATH.'Alipay'.DS);

		$alipay_config = load(ALI.'alipay.config.php');
		load(ALI.'alipay_submit.class.php');

		/**请求参数**/
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $info['id'];

        //订单名称，必填
        //$subject = $info['active_id'];
		$subject = $info['title'];

        //付款金额，必填
        $total_fee = $info['need_pay'];

        //商品描述，可空
        $body = $info['code'];

		/***********/

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service"       => $alipay_config['service'],
				"partner"       => $alipay_config['partner'],
				"seller_id"  => $alipay_config['seller_id'],
				"payment_type"	=> $alipay_config['payment_type'],
				"notify_url"	=> $alipay_config['notify_url'],
				"return_url"	=> $alipay_config['return_url'],
				
				"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
				"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
				//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
		        //如"参数名"=>"参数值"			
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;

		// dump($html_text);
	}

	public function aliGet()
	{
		/*需求介绍*///阿里回调接口 Z3JUdnluXm4mZXJxZWJeeg%3D%3D
		if( !G() )
			echoJson(array('status'=>FALSE));
		//接收参数
		define('ALI',VENDOR_PATH.'Alipay'.DS);
		$alipay_config = load(ALI.'alipay.config.php');
		load(ALI.'alipay_notify.class.php');

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		//dump(P());
		if($verify_result)
		{
			//支付宝交易号
			$trade_no = $_GET['trade_no'];

		    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') 
			{
				$id = $_GET['out_trade_no'];
				$true_pay = $_GET['total_fee'];
				$pay_time = strtotime(trim($_GET['notify_time']));

				$sql = "UPDATE `zxznz_order` SET 
										`status` 		= '2',
										`ali_no` 		= {$trade_no},
										`pay_time` 		= {$pay_time},
										`pay_type` 		= '1', 
										`true_pay` 		= {$true_pay}
										WHERE `id` 		= {$id}";

				$result = M('order')->exec($sql);
				if( $result !== FALSE )
				{
					header('Location:http://m.zxznz.cn/index.php?a=payok&orderId='.$id);
				}
				else
				{
					
				}
		    }
		    else 
			{
		      	header('Location:http://m.zxznz.cn/index.php?a=404');
		    }
		}
		else 
		{
			//header('Location:http://m.zxznz.cn/index.php?a=404');
		}
	}

	public function wxPay($info=null)
	{
		if( $info === null )
			echoJson(array('status'=>'006'));
		/*需求介绍*///微信支付接口 bG5Da2pebiZlcnFlYl56
		// dump($info,2);
		//定义路径常量
		define('WX',VENDOR_PATH.'Wxpay'.DS);
		//加载微信三方插件
		$list = Vendor('wxpay');
		//dump($list);
		$input = new \WxPayUnifiedOrder();
		$input->SetBody('上海纽珀');
		$input->SetAttach($info['id']);
		$input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($info['need_pay']*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag($info['title']);
		$input->SetNotify_url("http://m.zxznz.cn/index.php/Z3JUa2pebiZlcnFlYl56");
		$input->SetTrade_type("MWEB");
		// $input->SetTrade_type("WAP");
		$input->SetProduct_id($info['id']);
		//dump($input,2);
		$order = WxPayApi::unifiedOrder($input);
		dump($order,2);
	}
	public function wxGet()
	{
		/*需求介绍*///微信回调接口  Z3JUa2pebiZlcnFlYl56
	}
	public function wxJsPay()
	{
		/*需求介绍*///微信公众号支付中转  bG5DZldral5uJmVycWViXno%3D 
		/**///判断是否是微信浏览器请求
$MSG=<<<STR
<!DOCTYPE html>
	<html>
	    <head>
	        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	    </head>
	    <body>
	        <script type="text/javascript">      
	                document.head.innerHTML = '<title>抱歉，出错了</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"><link rel="stylesheet" type="text/css" href="https://res.wx.qq.com/open/libs/weui/0.4.1/weui.css">';
	                document.body.innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_info weui_icon_msg"></i></div><div class="weui_text_area"><h4 class="weui_msg_title">请在微信客户端打开链接</h4></div></div>';
	        </script>
	    </body>
	</html>
STR;
		if( ! is_weixin() )
			exit($MSG);
		//接收参数
		if( ! $id = G('activeId') )
			ERROR('非法请求！');
		/**///提取活动信息
		$info = M('Active')->One("SELECT id,title,price FROM `zxznz_active` WHERE `id` = {$id}");
		
		$list = Vendor('wxpay');
		
		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		
		$input->SetBody($info['title']);
		$input->SetAttach($info['id']);
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($info['price']*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetGoods_tag($info['title']);
		$input->SetNotify_url("http://m.zxznz/index.php/Z3JUZldral5uJmVycWViXno%3D");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		
		$order = WxPayApi::unifiedOrder($input);
		$jsApiParameters = $tools->GetJsApiParameters($order);
		//获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters();
		
		require_once(VENDOR_PATH.'confirmPay.html');
	}
	public function wxJsGet()
	{
		// /*需求介绍*///微信jsapi回调  Z3JUZldral5uJmVycWViXno%3D
		// $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		// define('WX',VENDOR_PATH.'Wxpay'.DS);

		// //为接收到数据
		// if( !$xml )
		// 	exit('FAIL');

		// /**///记录日志 （交易信息）
		// $time .= "【".date('Y-m-d H:i:s')."】\n";
		// $log = $time.$xml;
		// $log .= "\n\n";	
		// $filename = WX.'logs/JS'.date('Y').'-'.date('m').'-'.date('d').'.txt';
		// file_put_contents($filename, $log,FILE_APPEND);

		$xml = '<xml><appid><![CDATA[wxd6e9c8bc3130a666]]></appid>
<attach><![CDATA[test]]></attach>
<bank_type><![CDATA[CFT]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[Y]]></is_subscribe>
<mch_id><![CDATA[1448286702]]></mch_id>
<nonce_str><![CDATA[yenn8af4msuss3dhnw7tolzhpd3ew9go]]></nonce_str>
<openid><![CDATA[owt34v86zgSTrvdjHwSzHcwl2CNU]]></openid>
<out_trade_no><![CDATA[144828670220170413072617]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[D5BC1CBAEF5B5D51024391FD924E1237]]></sign>
<time_end><![CDATA[20170413152628]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[JSAPI]]></trade_type>
<transaction_id><![CDATA[4000462001201704136852145794]]></transaction_id>
</xml>';

		/**///形成订单信息
		$xmlArr=json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

		//判断结果
		$result_code 	= 	$xmlArr['result_code'];
		if( $result_code != 'SUCCESS' )
			exit('FAIL');

		//提取信息
		$active_id 		= 	$xmlArr['attach'];
		$ali_no 		=	$xmlArr['transaction_id'];
		$true_pay		=	$xmlArr['total_fee']/100;
		$openId 		=	$xmlArr['openid'];

		//组装数据
		$code 			=	'';
		$from 			=	'3';			//1.PC端2.手机端3.公众号4.其他
		$status 		=	'2';			//0.无状态1.未支付挂起2.已支付7.已取消
		$create_time	=	time();
		$pay_time		=	time();
		$pay_type 		=	'3';			//0.无状态1.支付宝2.微信3.公众号4.现金5.其他
		$count			=	'1';			//公众号支付没有选择数量机制  默认 1

		$sql = "INSERT INTO `zxznz_order`
					(`code` ,`from` ,`status` ,`create_time` ,`active_id` ,`pay_time` ,`true_pay` ,`pay_type` ,`count` ,`ali_no` )  
					VALUES
					('{$code}','{$from}','{$status}','{$create_time}',{$active_id},'{$pay_time}','{$true_pay}','{$pay_type}',$count,'{$ali_no}')";
		//储存订单信息
		$model = M('Order');
		$info = $model->exec($sql);
		dump($sql);
		if( $info === FALSE )
			exit('FAIL1');

		//储存openid
		$lastId = $model->lastInsertId();
		$sql = "INSERT INTO `zxznz_open` VALUES(null,$lastId,'{$openId}')";
		M('Open')->exec($sql);

		exit('SUCCESS');
	}
	
	/******************************/
	private static function getInfo($id=null)
	{
		$sql = "SELECT o.id,o.code,o.price,o.count,o.need_pay,a.title,a.intro,a.hospital,a.pic
							FROM `zxznz_order` AS o
							LEFT JOIN `zxznz_active` AS a ON o.active_id = a.id
							WHERE o.id = {$id} 
							LIMIT 1";
		$info = M('order')->One($sql);
		if( !$info )
			return FALSE;
		$info['title'] = htmlspecialchars_decode($info['title']);
		$info['intro'] = htmlspecialchars_decode($info['intro']);
		return $info;
	}
}

