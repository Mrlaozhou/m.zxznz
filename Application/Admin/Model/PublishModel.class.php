<?php 
namespace Admin\Model;
use Think\Model;
class PublishModel extends Model
{
	public $insertFields = array('title','intro','begin','action','is_show','is_top','create_time','bg','bg_type');
	public $updateFields = array('id','title','intro','begin','action','is_show','is_top','create_time','bg','bg_type');

	public $_validate = array(
		array('title','require','标题不能为空',1),
		array('action','require','行为不能为空',1),
		array('action','','行为名称已经存在！',0,'unique',1),
		array('begin','require','开始时间不能为空',1),
 		array('intro','require','介绍不能为空',1)
		);
	public $_auto = array(
		array('action','strtolower',3,'function'),
		array('begin','strtotime',3,'function'),
		array('create_time','time',1,'function'),
		);

	static private $_path = "./Application/Home/View/Publish/";

	protected function _before_insert(&$data,$options) 
    {
    	//上传页面
    	if( isset( $_FILES['html'] ) && $_FILES['html']['error'] === 0 )
    	{		
    		//实例化上传类
    		$upload = new \Think\Upload();

    		//配置
    		$upload->maxSize = 8*1024*1024;
    		$upload->exts = array('html');
    		$upload->rootPath = APP_PATH.'Home/View/';
    		$upload->savePath = 'Publish/';
    		$upload->autoSub  = FALSE;
    		$upload->saveName = $data['action'];
    		$upload->replace = TRUE;

    		//上传
    		$info = $upload->uploadOne( $_FILES['html'] );

    		//判断
    		if( !$info )
    		{
    			$this->error = $upload->getError();
    			return FALSE;  			
    		}
    	}

    	//上传背景图
    	if( isset( $_FILES['bg'] ) && $_FILES['bg']['error'] === 0 )
        {
            //实例化上传类
            $upload = new \Think\Upload();
            //配置
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg','png','gif','jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Publish_bg/';
            $upload->saveName = 'new_'.$data['action'].'_bg';
            //上传
            $info = $upload->uploadOne( $_FILES['bg'] );

            //判断--如果上传成功
            if( !$info )
            {
                $this->error = $upload->getError();
                return FALSE;
            }
            else
            {
            	$data['bg'] = $info['savepath'].$info['savename'];
            }
        }

        //上传图片压缩包
        if( isset( $_FILES['imgRar'] ) && $_FILES['imgRar']['error'] === 0 )
        {
            //实例化上传类
            $upload = new \Think\Upload();
            //配置
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('rar');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Publish_img/';
            $upload->autoSub  = FALSE;
            $upload->saveName = $data['action'];
            //上传
            $info = $upload->uploadOne( $_FILES['imgRar'] );

            //判断--如果上传成功
            if( !$info )
            {
                $this->error = $upload->getError();
                return FALSE;
            }
            //上传成功、解压压缩包
            UnRar(__UPLOADS__.'Publish_img/'.$data['action'].'.rar',__UPLOADS__.'Publish_img/',TRUE);
        }
    }
    protected function _before_update(&$data,$options) 
    {
    	/************处理页面************/
        //判断行为是否该变
        $info = $this->field('action')
        			   ->find($options['where']['id']);
        $action = $info['action'];
        if( $data['action'] == $action )
        {
        	//没有改变 判断是否有上传文件
        	if( isset( $_FILES['html'] ) && $_FILES['html']['error'] === 0 )
	    	{		
	    		//实例化上传类
	    		$upload = new \Think\Upload();

	    		//配置
	    		$upload->maxSize = 8*1024*1024;
	    		$upload->exts = array('html');
	    		$upload->rootPath = APP_PATH.'Home/View/';
	    		$upload->savePath = 'Publish/';
	    		$upload->autoSub  = FALSE;
	    		$upload->saveName = $data['action'];
	    		$upload->replace = TRUE;

	    		//上传
	    		$info = $upload->uploadOne( $_FILES['html'] );

	    		//判断
	    		if( !$info )
	    		{
	    			$this->error = $upload->getError();
	    			return FALSE;  			
	    		}
	    	}
        }
        else
        {
        	//行为改变  有文件上传
        	if( isset( $_FILES['html'] ) && $_FILES['html']['error'] === 0 )
	    	{
	    		//实例化上传类
	    		$upload = new \Think\Upload();

	    		//配置
	    		$upload->maxSize = 8*1024*1024;
	    		$upload->exts = array('html');
	    		$upload->rootPath = APP_PATH.'Home/View/';
	    		$upload->savePath = 'Publish/';
	    		$upload->autoSub  = FALSE;
	    		$upload->saveName = $data['action'];
	    		$upload->replace = TRUE;

	    		//上传
	    		$info = $upload->uploadOne( $_FILES['html'] );

	    		//判断
	    		if( !$info )
	    		{
	    			$this->error = $upload->getError();
	    			return FALSE;  			
	    		}
	    		else
	    		{
	    			@unlink("./Application/Home/View/Publish/{$action}.html");
	    		}
	    	}
	    	else
	    	{
	    		//没有文件上传 ===> 修改原始文件名
	    		@rename(self::$_path.$action.'.html',self::$_path.$data['action'].'.html');
	    	}

            //行为改变  没有.rar
            if( !isset( $_FILES['imgRar'] ) || $_FILES['imgRar']['error'] != 0)
            {
                @rename(__UPLOADS__.'Publish_img/'.$action,__UPLOADS__.'Publish_img/'.$data['action']);
            }
        }

       /************处理背景图************/
       //上传背景图
    	if( isset( $_FILES['bg'] ) && $_FILES['bg']['error'] === 0 )
        {
            //删除磁盘上的旧照片
            $info = $this->field('bg')->find($options['where']['id']);
            @unlink(__UPLOADS__.$info['bg']);

            //实例化上传类
            $upload = new \Think\Upload();
            //配置
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg','png','gif','jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Publish_bg/';
            $upload->saveName = 'new_'.$data['action'].'_bg';
            //上传
            $info = $upload->uploadOne( $_FILES['bg'] );

            //判断--如果上传成功
            if( !$info )
            {
                $this->error = $upload->getError();
                return FALSE;
            }
            else
            {
            	$data['bg'] = $info['savepath'].$info['savename'];
            }
        }

       /************处理图片文件夹************/
       if( isset( $_FILES['imgRar'] ) && $_FILES['imgRar']['error'] === 0 )
        {
            //删除之前解压的文件夹
            remove_dir(__UPLOADS__.'Publish_img/'.$action);

            //实例化上传类
            $upload = new \Think\Upload();
            //配置
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('rar');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Publish_img/';
            $upload->autoSub  = FALSE;
            $upload->saveName = $data['action'];
            //上传
            $info = $upload->uploadOne( $_FILES['imgRar'] );

            //判断--如果上传成功
            if( !$info )
            {
                $this->error = $upload->getError();
                return FALSE;
            }
            //上传成功、解压压缩包
            UnRar(__UPLOADS__.'Publish_img/'.$data['action'].'.rar',__UPLOADS__.'Publish_img/',TRUE);
        }
    }
    protected function _before_delete($options) 
    {
        //提取信息
        $info = $this->field('action,bg')
                     ->find($options['where']['id']);
        //删除页面信息（.html）
        @unlink(self::$_path.$info['action'].'.html');
        //删除背景图片
        @unlink(__UPLOADS__.$info['bg']);

        //删除图片文件夹
        remove_dir(__UPLOADS__.'Publish_img/'.$info['action']);
    }   
}