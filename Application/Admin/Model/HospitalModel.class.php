<?php 
namespace Admin\Model;
use Think\Model;

class HospitalModel extends Model
{
	protected $insertFields = array('name','province','city','detial','tel','score_number','score_total','comment_number','logo','picture','intro','is_show','is_index','is_top');
	protected $updataFields = array('id','name','province','city','detial','tel','score_number','score_total','comment_number','logo','picture','intro','is_show','is_index','is_top');
    protected $_validate = array(
                array('name','require','医院名称不能为空',1),
                array('province','require','省份信息不能为空',1),
                array('city','require','城市信息不能为空',1),
                array('detial','require','地址详细信息不能为空',1),
                array('tel','require','医院电话不能为空',1),
                array('intro','require','医院介绍不能为空',1),
                );

    protected function _before_insert(&$data,$options) 
    {
        //
        $data['is_top'] = (int)$data['is_top'];
        //拼接地址
        $data['address'] = trim(I('post.province')).'-'.trim(I('post.city')).'-'.trim(I('post.detial'));
        /**********上传医院照片**********/
        if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
        {
            //实例化文件上传类
            $upload = new \Think\Upload();
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Hospital/';

            //单文件上传
            $info = $upload->uploadOne($_FILES['logo']);

            //判断是否上传成功
            if( $info )
            {
                // dump($info);
                // array(9) {
                //   ["name"] => string(5) "1.jpg"
                //   ["type"] => string(10) "image/jpeg"
                //   ["size"] => int(126293)
                //   ["key"] => int(0)
                //   ["ext"] => string(3) "jpg"
                //   ["md5"] => string(32) "53974f23919ac65d727c56911113c7bd"
                //   ["sha1"] => string(40) "1f71633d138c7f450782ce00fec33bfa26db98d5"
                //   ["savename"] => string(17) "5873564a87c6b.jpg"
                //   ["savepath"] => string(20) "Hospital/2017-01-09/"
                // }
                $data['logo'] = $info['savepath'].$info['savename'];

                //处理图片宽高
                //changeImage($img,$path,$width,$height,$saveName,$type = 6)
                // $oldLogo = $data['logo'];
                // $data['logo'] = changeImage(__UPLOADS__.$oldLogo,__UPLOADS__,490,490,$oldLogo);
            }
            else
            {
                $this->error($upload->getError());
                return FALSE;
            }
        }
    }

    protected function _after_insert($data,$options)
    {
        /********上传图片集********/
        if( checkPic($_FILES['pic']['error']) )
        {
            //接收处理后的结果集
            $result = dealPic($_FILES['pic']);

            //实例化上传文件类
            $upload = new \Think\Upload();
            //配置参数
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Hos_img/';

            foreach($result as $k => $v)
            {
                if( $v['error'] === 0 )
                {
                    //上传图片集
                    $info = $upload->uploadOne($v);

                    //实例化  Hos_img类
                    $HImodel = M('hos_img');
                    //拼接路径
                    $path = $info['savepath'].$info['savename'];

                    //添加入库
                    $HImodel->add(array(
                        'hos_id'        =>  $data['id'],
                        'path'          =>  $path,
                        ));
                }
            }
        }
        /*********添加医院分类********/
        $typeIds = I('post.type_ids');
        if( !empty($typeIds) )
        {
            $HTmodel = M('Hos_type');

            foreach( $typeIds as $k => $v )
            {
                $HTmodel->add(array(
                    'hos_id'        =>  (int)$data['id'],
                    'type_id'       =>  (int)$v,
                    ));
            }            
        }
    }

    protected function _before_update(&$data,$options) 
    {
        //
        $data['is_top'] = (int)$data['is_top'];
        //拼接地址
        $data['address'] = trim(I('post.province')).'-'.trim(I('post.city')).'-'.trim(I('post.detial'));

        /********更新logo*******/
        if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
        {
            //删除磁盘上的旧信息
            $info = $this->field('logo')->find($options['where']['id']);

            @unlink(__UPLOADS__.$info['logo']);

            //实例化文件上传类
            $upload = new \Think\Upload();
            $upload->maxSize = 8*1024*1024;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Hospital/';

            //单文件上传
            $info = $upload->uploadOne($_FILES['logo']);

            //判断是否上传成功
            if( $info )
            {
                $data['logo'] = $info['savepath'].$info['savename'];
                
                //处理图片宽高
                //changeImage($img,$path,$width,$height,$saveName,$type = 6)
                // $oldLogo = $data['logo'];
                // $data['logo'] = changeImage(__UPLOADS__.$oldLogo,__UPLOADS__,490,490,$oldLogo);
            }
            else
            {
                $this->error($upload->getError());
                return FALSE;
            }
        }

        /*******更新（添加）picture********/
        if( isset($_FILES['pic']) )
        {
            if( checkPic($_FILES['pic']['error']) )
            {
                //接收处理后的结果集
                $result = dealPic($_FILES['pic']);

                //实例化上传文件类
                $upload = new \Think\Upload();
                //配置参数
                $upload->maxSize = 8*1024*1024;
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath = './Public/Uploads/';
                $upload->savePath = 'Hos_img/';

                foreach($result as $k => $v)
                {
                    if( $v['error'] === 0 )
                    {
                        //上传图片集
                        $info = $upload->uploadOne($v);

                        //实例化  Hos_img类
                        $HImodel = M('hos_img');
                        //拼接路径
                        $path = $info['savepath'].$info['savename'];

                        //添加入库
                        $HImodel->add(array(
                            'hos_id'        =>  $options['where']['id'],
                            'path'          =>  $path,
                            ));
                    }
                }
            }           
        }
        /*************************/
        $typeIds = I('post.type_ids');
        if( !empty($typeIds) )
        {
            $HTmodel = M('Hos_type');

            //删除旧信息
            $HTmodel->where(array('hos_id'=>(int)$options['where']['id']))->delete();

            foreach( $typeIds as $k => $v )
            {
                $HTmodel->add(array(
                    'hos_id'        =>  (int)$options['where']['id'],
                    'type_id'       =>  (int)$v,
                    ));
            }            
        }
    }

    protected function _after_update($data,$options) {} 

    protected function _before_delete($options) 
    {
        //接收 hos_id，删除磁盘信息
        $hos_id = $options['where']['id'];
        $info = $this->find($hos_id);
        @unlink(__UPLOADS__.$info['logo']);

        /********删除医院picture集********/
        $HImodel = M('hos_img');        
        //删除磁盘上picture信息出错
        //查询磁盘信息
        $infos = $HImodel->field('path')
                         ->where(array(
                            'hos_id'        =>  array('eq',$hos_id),
                            ))
                         ->select();

        if( $infos )
        {
            //如果磁盘上存在图片集信息-----删除
            foreach($infos as $k => $v)
            {
                @unlink(__UPLOADS__.$v['path']);
            }
            //删除表中信息
            $result = $HImodel->where(array(
                    'hos_id'        =>  array('eq',$hos_id),
                    ))
                              ->delete();
            if( !$result )
            {
                $this->error = '删除hos_img中信息出错！';
                return FALSE;
            }
        }

        /********删除医院医生信息********/
        //实例化Doctor模型类
        $Dmodel = D('Doctor');

        $Dinfos = $Dmodel->field('id,picture')
                         ->where(array(
            'hos_id'        =>  array('eq',$options['where']['id']),
            ))->select();

        if( $Dinfos )
        {
            foreach($Dinfos as $k => $v)
            {
                @unlink(__UPLOADS__.$v['picture']);
                $Dmodel->delete($v['id']);                
            }

        }
        /*********删除医院分类信息********/
        //实例化hos_type
        $HTmodel = M('Hos_type');
        $HTmodel->where(array('hos_id'=>(int)$options['where']['id']))->delete();
    }    

    protected function _after_delete($data,$options) 
    {

    } 

    public function search()
    {
    	//解析当前数据页数
    	$p = I('get.p');

        $current = empty($p) ? $p : 1;

        //获取当前表中的信息条数
        $count = $this->count();

        //每页显示
        $pagesize = 8;

    	//实例化分页类
    	$page = new \Think\Page($count,$pagesize);
        $showPage = $page->show();

        //排序显示
        $odby = 'id desc';

    	//查询数据
        $where = array();

    	$data = $this->field('*')
    				 ->where($where)
    				 ->limit($page->firstRow.','.$page->listRows)
    				 ->order($odby)
    				 ->select();

        //返回数据
        return array(
            'page'      =>  $showPage,
            'data'      =>  $data,
            );
    }      
}