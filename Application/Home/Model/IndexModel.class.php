<?php 
namespace Home\Model;

class IndexModel
{
	/**
	 * [getHos description]
	 * @param  integer $size [轮播数  默认为 2]
	 * @return [type]        [返回分割后的数据]
	 */
	public function getHos($size = 2)
	{
		//实例化hospital模型类
		$hospital = D('Admin/Hospital');

		//提取数据
        $Hinfo = $hospital->field('id,name,logo')
                          ->where(array(
                            'is_show'   => array('eq','1'),
                            'is_index'  => array('eq','1'),
                            ))
                          ->limit($size*5)
                          ->order('is_top desc')
                          ->select();
        //每片轮播是5条信息
        return array_chunk($Hinfo,5);
	}


    /*2.22日  更改需求为自动更新*/
	public function getDoc($size = 2)
	{
		$doctor = D('Admin/Doctor');
        $Dinfo = $doctor->alias('d')
        				->join("LEFT JOIN zxznz_hospital AS h ON d.hos_id=h.id")
        				->field('d.id,d.name,d.picture,(h.name)hos_name')
                        ->where(array(
                            'd.is_show'   =>  array('eq','是'), 
                            // 'h.is_show'   =>  array('eq','1'),    //所属医院是否显示
                            // 'd.is_index'	=>	array('eq','1'),
                            ))
                        ->limit($size*4)
                        // ->order('d.is_top desc')
                        ->order('d.id desc')
                        ->select();

        return $Dinfo;
	}
}