<?php 
namespace Home\Model;
use Think\Model;
class HreplyModel extends Model
{
	public $insertFields = array('hos_id','cmt_id','user_id','user_name','content','time');
	public $updateFields = array('id','hos_id','cmt_id','user_id','user_name','content','time');

	public $_validete = array(
			array('cmt_id','require','评论信息不能为空',1),
			array('user_id','require','不存在用户信息',1),
			array('user_name','require','不存在用户信息',1),
			array('content','require','评论内容不能为空！',1),
			);
	public $_auto = array(
			array('content','trim',1,'function'),
			array('content','preventTags',1,'function'),
			array('time','time',1,'function'),
			);
}