<?php
namespace Api\Controller;
use Api\Controller\PhoneController;
// +----------------------------------------------------------------------
// | 移动端主页数据接口
// +----------------------------------------------------------------------
// | detial:	doctor hospital active 
// +----------------------------------------------------------------------
class IndexController extends PhoneController
{
	public function index()
	{
		if( 1 )
		{
			/*********实例化模型********/
			
			//实例化医生信息
			$Dmodel = M('Doctor');
			//实例化医院信息
			$Hmodel = M('Hospital');
			
			/*******医生数据*******/// 12条信息
			$Ddata =  $Dmodel->alias('d')
        					 ->join("LEFT JOIN zxznz_hospital AS h ON d.hos_id=h.id")
        				     ->field('d.id,d.name,d.picture,(h.name)hos_name')
                             ->where(array(
                            	 
                            	'h.is_show'   =>  array('eq','1'),    //所属医院是否显示
                           		
                            		))
                        	->limit(12)
							->order('d.id desc')
                        	->select();
			/*******医院数据*******/// 9 条信息
			$Hdata = $Hmodel->field('id,name,logo')
							->where(array(
								'is_show'	=>	array('eq','1'),
								'is_index'	=>	array('eq','1'),
							))
							->limit(9)
							->order('is_top desc')
							->select();
			/******处理数据*****/
			$doctor = array_chunk($Ddata,4);
			$hospital = array_chunk($Hdata,3);
			
			if( $Ddata && $Hdata )
			{
				echo json_encode(array(
							'status'	=>	TRUE,
							'doctor'	=>	$doctor,
							'hospital'	=>	$hospital,
							));
			}
			else
			{
				echo json_encode(array(
							'status'	=>	FALSE,
							'info'		=>	'002',
							));
			}		
		}
		else
		{
			echo json_encode(array(
							'status'	=>	FALSE,
							'info'		=>	'001',
							));
		}
	}
}