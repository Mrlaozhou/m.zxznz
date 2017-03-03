<?php 
namespace Admin\Model;
use Think\Model;

class TypeModel extends Model
{
	protected $insertFields = array('type_name','parent_id');
	protected $updateFields = array('id','type_name','parent_id');

	protected $_validate = array(
		array('type_name','require','分类名称不能为空！',1),
		);


	protected function _before_delete($options)
	{
		//当前操作 Id
		$id = $options['where']['id'];

		//取得当前Id  的所有 子Id	
		$Ids = $this->_getChildrenIds($id,false);

		if( $Ids )
		{
			foreach($Ids as $k => $v)
			{
				$this->delete($v);
			}		
		}
	}
	public function _getChildrenIds($id,$isSelf = TRUE)
	{
		//取得所有数据
		$data = $this->select();
		//判断
		if ( $data )
		{
			$sortData = getSort($data,$id,0,true);	

			//声明空数组  储存IDs 
			$Ids = array();
			
			if( $sortData )
			{

				foreach( $sortData as $k => $v )
				{
					$Ids[] = $v['id'];
					unset($sortData[$k]);
				}
			}
			if( $isSelf )
			{
				$Ids[] = ''.$id;		
			}
		}
		return $Ids;
	}

	public function getChildren()
	{
		//取得当前 ID
		$id = I('get.id');
		//获取当前信息的 子Id 集
		$Ids = $this->_getChildrenIds($id);

		//获取所信息
		return 	$data = $this->where(array(
						'id'	=>	array('not in',implode(',',$Ids)),
						))
							 ->select();
	}
}