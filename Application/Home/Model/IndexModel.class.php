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

    /*********/
    public function rExists($config)
    {
        
        //验证格式
        $phone = trim($config);

        $pattern = '/^1[34578]\d{9}$/';
        $zz = preg_match($pattern,$phone);

        if( $zz )
        {
            /*验证手机号*/
            $model = M('User');
            
            $result = $model->field('username')
                            ->where(array(
                                'username'  =>  array('eq',$phone),
                                ))
                            ->find();

            if( !empty($result) )
            {
                if( $result['username'] == $phone )
                {
                    return 2;
                }
                else
                {
                    return 3;                        
                }
            }
            else
            {
                return TRUE;     
            }
        }
        else
        {
            return 1;
        }       
    }
    public function rAlias($config)
    {
        $alias = trim($config);

        $pattern = '/((?=[\x21-\x7e]+)[^A-Za-z0-9])/';
        $result = preg_match($pattern,$alias);

        if( !$result )
        {
            $len = strlen($alias);

            if( $len>=3 && $len<=30 )
            {
                return TRUE;
            }
            else
            {
                return 2;                
            }                
        }
        else
        {
            return 1;
        }
    }
    public function rPwd($config)
    {
        $pwd = trim($config);

        $pattern = '/^[0-9a-zA-Z]+$/';
        $result = preg_match($pattern,$pwd);

        if( $result )
        {
            $len = strlen($pwd);

            if( $len>=6 && $len<=12 )
            {
                return TRUE;
            }
            else
            {
                return 2;
            }
        }
        else
        {
            return 1;
        }
    }
    public function rPwd2($config)
    {  
        if( $config['new'] !== $config['old'] )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        } 
    }
    /*********/
}