<?php
namespace Admin\Model;
use Think\Model;

class DoctorModel extends Model
{
	protected $insertFields = array('hos_id','name','picture','duty','number','good','is_show','title','edu','sex','pass','intro','start','is_index');
	protected $updateFields = array('id','hos_id','name','picture','duty','number','good','score_total','score_number','is_show','title','edu','sex','pass','intro','start','is_index');
	protected $_validate = array(
			array('hos_id','require','未发现医院ID!联系老周',1),
			array('name','require','请填写姓名！',1),
			array('duty','require','请填写职务！',1),
			array('title','require','请填写职称！',1),
			array('start','require','请填写从行时间！',1),
			array('edu','require','请选择学历！',1),
			array('good','require','请填写擅长技能！',1),
			array('intro','require','请填写医生简介！',1),
		);
	protected function _before_insert(&$data,$options)
	{
		//整合经历信息
		$data['pass'] = array_filter($data['pass']);
		$data['pass'] = implode("-----",$data['pass']);

		/******处理good数据******/
		$data['good'] = str_replace('，',',',$data['good']);
		/*****上传医生图片*****/
		if( isset($_FILES['picture']) && $_FILES['picture']['error'] === 0 )
		{
			//实例化上传类
			$upload = new \Think\Upload();
			//设置参数
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Doctor/';
            //上传
            $info = $upload->uploadOne($_FILES['picture']);
            //判断
            if( $info )
            {
            	$data['picture'] = $info['savepath'].$info['savename'];

            	//处理图片宽高
                //changeImage($img,$path,$width,$height,$saveName,$type = 6)
                //$oldLogo = $data['picture'];
                //$data['picture'] = changeImage(__UPLOADS__.$oldLogo,__UPLOADS__,250,250,$oldLogo);
            }
            else
            {
            	$this->error = $upload->getError();
            	return FALSE;
            }
		}
		else
		{
			$this->error = "图片信息有误！";
			return FALSE;
		}
	}

	protected function _before_update(&$data,$options)
	{
		//整合经历信息
		$data['pass'] = array_filter($data['pass']);
		$data['pass'] = implode("-----",$data['pass']);
		
		/******处理good数据******/
		$data['good'] = str_replace('，',',',$data['good']);
		/*****更新医生图片*****/
		if( isset($_FILES['picture']) && $_FILES['picture']['error'] === 0 )
		{
			//删除原医生信息
			$info = $this->field('picture')->find($options['where']['id']);

			@unlink(__UPLOADS__.$info['picture']);

			//实例化上传类
			$upload = new \Think\Upload();
			//设置参数
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Doctor/';
            //上传
            $info = $upload->uploadOne($_FILES['picture']);
            //判断
            if( $info )
            {
            	$data['picture'] = $info['savepath'].$info['savename'];
            	
            	//处理图片宽高
                //changeImage($img,$path,$width,$height,$saveName,$type = 6)
                //$oldLogo = $data['picture'];
                //$data['picture'] = changeImage(__UPLOADS__.$oldLogo,__UPLOADS__,250,250,$oldLogo);
            }
            else
            {
            	$this->error = $upload->getError();
            	return FALSE;
            }
		}
	}

	protected function _before_delete($options)
	{
		//删除磁盘上的图片
		//查询信息
		$info =	$this->field("picture")
					 ->find($options['where']['id']);
		//删除磁盘的信息
		@unlink(__UPLOADS__.$info['picture']);
	}

	public function search()
	{
		//接收医院ID
		$hos_id = I('get.hos_id');

   		//解析当前数据页数
    	$p = I('get.p');

        $current = empty($p) ? $p : 1;

        //获取当前表中的信息条数
        $count = $this->where(array(
        	'is_show'		=>		array('eq','是'),
			'hos_id'		=>		array('eq',$hos_id),
        	))->count();

        //每页显示
        $pagesize = 8;

    	//实例化分页类
    	$page = new \Think\Page($count,$pagesize);
        $showPage = $page->show();

        //查询条件

        $where['hos_id'] = array('eq',$hos_id);

        //排序显示
        $odby = 'id desc';

		$infos = $this->field("*")
				->where($where)
				->order($odby)
				->limit($page->firstRow.",".$page->listRows)
				->select();
		return array(
			'page'		=>	$showPage,
			'infos'		=>	$infos,
			);
	}
}