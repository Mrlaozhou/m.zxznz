<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index()
    {
        /*******数据提取*******/
        $model = D('Home/Index');

        //doctor
        $Dinfo = $model->getDoc();

        
        //hospital
        $Hinfo = $model->getHos();


    	$this->assign(array(
    		'page_title' => '智慧医美_整形指南针',
    		'page_desc'	 => 'e折整形 全国抢购',

            'Dinfo'      => $Dinfo,
            'Hinfo'      => $Hinfo,
    		));
        $this->display();
    }

    public function ours()
    {
		$this->assign(array(
    		'page_title' => '关于我们_智慧医美_整形指南针',
    		'page_desc'	 => 'e折整形 全国抢购',
    		));
        $this->display();
    }

    public function login()
    {
        if ( IS_POST )
        {
            // dump( I('post.') );
            // exit;

            $model = new \Home\Model\UserModel();
            $status = $model->checkLogin( I('post.') );

            //根据model 返回的值  执行结果
            switch ($status)
            {
                case 0:
                    $this->error('您输入的用户名有误，请核对后再次输入');
                    break;
                case -7:
                    $this->error('您输入的密码有误，请核对后再次输入');
                    break;
                default:
                    // 更新  最新操作时间
                    $model->last_time = time();
                    //登录成功  跳转
                    $this->success('登录成功！', U('index') );
            }
        }
        else
        {
            $this->display();
        }
    }

    public function register()
    {
        header("Access-Control-Allow-Origin:*");
        if( 1 )
        {
            $model = new \Home\Model\UserModel();
            if ( $model->create( I('post.') , 1 ) )
            {
                if ( $model->add() )
                {
                    echo json_encode(array(
                        'status'    =>  TRUE,
                        ));
                }
                else
                {
                    echo json_encode(array(
                        'status'    =>  FALSE,
                        'info'      =>  '001',
                        ));
                }
            }
            else
            {
                echo json_encode(array(
                    'status'    =>  FALSE,
                    'info'      =>  '002',
                    ));
            }
        }
        else
        {
            echo 'hahaha';
        }
    }

    public function outLogin()
    {

        // 清空 session 重定向
        session(null);
        redirect('/');
    }

    public function checkExists()
    {
        header("Access-Control-Allow-Origin:*");
        //接受参数
        $config = I('post.');

        if( !empty( $config ) )
        {
            //验证格式
            $phone = trim($config['phone']);

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
                        echo json_encode(array(
                            'status'    =>  FALSE,
                            'info'      =>  '003',      //此手机已注册
                            ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'status'    =>  FALSE,
                            'info'      =>  '004',      //恶意攻击
                            ));                         
                    }
                }
                else
                {
                    echo json_encode(array(
                        'status'    =>  TRUE,
                        'info'      =>  null,
                    ));     
                }
            }
            else
            {
                echo json_encode(array(
                    'status'    =>  FALSE,
                    'info'      =>  '002',      //参数可能出错！
                    ));
            }       
        }
        else
        {
            echo json_encode(array(
                'status'    =>  FALSE,
                'info'      =>  '001',      //传参、接参出错！
                ));
        }
    }

    public function sendMsg()
    {
        header("Access-Control-Allow-Origin:*");
        //参数
        $mobile = trim(I('get.mobile'));

        if( $mobile )
        {
            //url
            $url = 'http://106.ihuyi.com/webservice/sms.php?method=Submit';
            //账户、密码
            $account = 'C22986809';
            $password = '37454a5b2e36e986562439659c74c928';

            //生成随机验证码
            $rand = getRandStr(4,2);

            //拼接信息
            $content = "您的验证码是：{$rand}。请不要把验证码泄露给其他人。【整形指南整】"; 
            $post_data = "account={$account}&password={$password}&mobile={$mobile}&content=".rawurlencode($content)."format=json";

            $result = POST($post_data,$url)
            if( $result == 2 )
            {
                echo json_encode(array(
                    'status'    =>  TRUE,
                    ));
            }
            else
            {
                echo json_encode(array(
                    'status'    =>  TRUE,
                    'info'      =>  $post_data
                    ));                
            }

        }
        else
        {
            echo json_encode(array(
                'status'    =>  FALSE,
                'info'      =>  '001',
                ));
        }
    }

    public function checkAlias()
    {
        header("Access-Control-Allow-Origin:*");
        $config = I('post.');
        if( $config )
        {
            $alias = trim($config['alias']);

            $pattern = '/((?=[\x21-\x7e]+)[^A-Za-z0-9])/';
            $result = preg_match($pattern,$alias);

            if( !$result )
            {
                $len = strlen($alias);

                if( $len>=3 && $len<=30 )
                {
                    echo json_encode(array(
                        'status'    =>  TRUE,
                        'info'      =>  $len,
                        ));
                }
                else
                {
                    echo json_encode(array(
                        'status'    =>  FALSE,
                        'info'      =>  '005',       
                        ));                
                }                
            }
            else
            {
                echo json_encode(array(
                    'status'    =>  FALSE,
                    'info'      =>  '002',
                    ));
            }
        }
        else 
        {
            echo json_encode(array(
                'status'    =>  FALSE,
                'info'      =>  '001',          //传参 出错      
                ));
        }    
    }

    public function checkPwd()
    {
        header("Access-Control-Allow-Origin:*");
        $config = I('post.');
        if( $config )
        {
            $pwd = trim($config['pwd']);

            $pattern = '/^[0-9a-zA-Z]+$/';
            $result = preg_match($pattern,$pwd);

            if( $result )
            {
                $len = strlen($pwd);

                if( $len>=6 && $len<=12 )
                {
                    echo json_encode(array(
                        'status'    =>  TRUE,
                        'info'      =>  $len,
                        ));
                }
                else
                {
                    echo json_encode(array(
                        'status'    =>  FALSE,
                        'info'      =>  '005'       //长度不允许
                        ));
                }
            }
            else
            {
                echo json_encode(array(
                    'status'    =>  FALSE,
                    'info'      =>  '002',          //参数出错
                    ));
            }
        }
        else
        {
            echo json_encode(array(
                'status'    =>  FALSE,
                'info'      =>  '001',          //传参 出错
                ));
        }
    }

    public function checkRepeat()
    {
        header("Access-Control-Allow-Origin:*");
        $config = I('post.');
        if( $config )
        {
            if( $config['pwd'] && $config['pwd2'] )
            {
                if( trim($config['pwd']) == trim($config['pwd2']) )
                {
                    echo json_encode(array(
                        'status'    =>  TRUE,
                        ));
                }
                else
                {
                    echo json_encode(array(
                        'status'    =>  FALSE,
                        'info'      =>  '!003'
                        ));
                }
            }
            else
            {
                echo json_encode(array(
                    'status'    =>  FALSE,
                    'info'      =>  '0011',          //传参 出错
                    ));
            }
        }
        else
        {
            echo json_encode(array(
                'status'    =>  FALSE,
                'info'      =>  '001',          //传参 出错
                ));
        }
    }
}