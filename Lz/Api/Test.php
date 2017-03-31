<?php 

class Test extends Base
{
	public function index()
	{
		if( Vendor('wxpay') === FALSE )
			Error('t1');
		$notify = new \NativePay();
		//配置参数
		$input = new \WxPayUnifiedOrder();
		$input->SetBody('haha');
		$input->SetAttach("test");
		$input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee(100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("");
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id(38);
		$result = $notify->GetPayUrl($input);
		$url = urlencode($result["code_url"]);
		dump($url);
	}
}