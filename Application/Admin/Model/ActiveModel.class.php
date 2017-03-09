<?php 
namespace Admin\Model;
use Think\Model;
class ActiveModel extends Model
{
	public $insertFields = array('title','pic','intro','object','start_time','end_time','location','price','join_num','create_time','is_top','is_show','status');
    public $updateFields = array('id','title','pic','intro','object','start_time','end_time','location','price','join_num','create_time','is_top','is_show','status');

	public $_validate = array(
		array('title','require','活动标题不能为空',1),
		array('location','require','地址不能为空',1),
		array('start_time','require','未设置开始时间',1),
		array('end_time','require','未设置结束时间',1),
		array('intro','require','活动详情不能为空',1),
		);
	public $_auto = array(
		array('start_time','strtotime',3,'function'),
		array('end_time','strtotime',3,'function'),
		array('create_time','time',1,'function'),
		);

    // 插入数据前的回调方法
    protected function _before_insert(&$data,$options) 
    {
    	//数据处理
    	$data['object'] = str_replace("，",",",$data['object']);
    	/**********上传图片***********/
    	if( isset( $_FILES['pic'] ) && $_FILES['pic']['error'] === 0 )
    	{
    		//实例化上传类
    		$upload = new \Think\Upload();
    		//配置
    		$upload->maxSize = 8*1024*1024;
    		$upload->exts = array('jpg','png','gif','jpeg');
    		$upload->rootPath = './Public/Uploads/';
    		$upload->savePath = 'Active/';
    		//上传
    		$info = $upload->uploadOne( $_FILES['pic'] );

    		//判断
    		if( $info )
    		{
    			//路径
    			$data['pic'] = $info['savepath'].$info['savename'];

    			//修改图片尺寸
    			//changeImage($img,$path,$width,$height,$saveName,$type = 6)
                //$oldPic = $data['pic'];
                //$data['pic'] = changeImage(__UPLOADS__.$oldPic,__UPLOADS__,550,300,$oldPic);
    		}else
    		{
    			$this->error = $upload->getError();
    			return FALSE;
    		}
    	}
    }
    // 插入成功后的回调方法
    protected function _after_insert($data,$options) {}


    // 更新数据前的回调方法
    protected function _before_update(&$data,$options) 
    {
        $data['object'] = str_replace("，",",",$data['object']);
        /**********上传图片***********/
        if( isset( $_FILES['pic'] ) && $_FILES['pic']['error'] === 0 )
        {
            //删除磁盘上的旧照片
            $info = $this->field('pic')->find($options['where']['id']);
            @unlink(__UPLOADS__.$info['pic']);

            //实例化上传类
            $upload = new \Think\Upload();
            //配置
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg','png','gif','jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Active/';
            //上传
            $info = $upload->uploadOne( $_FILES['pic'] );

            //判断--如果上传成功
            if( $info )
            {
                //路径
                $data['pic'] = $info['savepath'].$info['savename'];

                //修改图片尺寸
                //changeImage($img,$path,$width,$height,$saveName,$type = 6)
                // $oldPic = $data['pic'];
                // $data['pic'] = changeImage(__UPLOADS__.$oldPic,__UPLOADS__,550,300,$oldPic);
            }else
            {
                $this->error = $upload->getError();
                return FALSE;
            }
        }
    }
    // 更新成功后的回调方法
    protected function _after_update($data,$options) {} 

    // 删除数据前的回调方法
    protected function _before_delete($options) 
    {
        //获取磁盘图片路径
        $info = $this->field('pic')->find($options['where']['id']);

        @unlink(__UPLOADS__.$info['pic']);
    }    
    // 删除成功后的回调方法
    protected function _after_delete($data,$options) {}

    public function search()
    {
    	//接受参数
		//参数格式为 index.php/w/id-ep-X/desc/id-des
		//where 条件
    	$w = I('get.w') ? explode( '-', I('get.w')) : null;
    	if( !empty($w) )
    	{
    		$where[$w[0]] = array("{$w[1]}",$w[2]);
    	}
    	else
    	{
    		$where = '1';
    	}
    	//desc 条件
    	$desc = I('get.desc') ? explode(' ',I('get.desc')) : 'id desc';

    	//分页
    	$count = $this->count();

    	$pagesize = 8;

    	$page = new \Think\Page($count,$pagesize);
    	$pageString = $page->show();

    	$data = $this->field('id,title,pic,object,start_time,end_time,location,join_num,is_top,is_show,status,create_time')
    				 ->where($where)
    				 ->limit($page->firstRow.','.$page->listRows)
    				 ->order($desc)
    				 ->select();

    	return $data = array(
    		'page'		=>	$pageString,
    		'data'		=>	$data,
    		);
    }
}