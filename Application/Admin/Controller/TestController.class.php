<?php 
namespace Admin\Controller;
use Think\Controller;
class TestController extends BaseController{
	public function index(){
		$a = 3;
		$b = 3;
		if( $a=5 || $b=5 )
		{
			$a++;
			$b++;
		}
		echo "$a,$b";
	}
}


