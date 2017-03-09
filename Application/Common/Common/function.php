<?php 


/**
 * [sendEmail 发送邮箱接口]
 * @return [type] [description]
 */
function sendEmail($subject,$msghtml,$sendTo)
{
	require_once('./PHPMailer/class.phpmailer.php');

	//实例化邮箱对象
	$mail = new PHPMailer();


	/*服务器相关信息*/
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->Host 	= 'smtp.163.com';

	//服务器 ，本公司的邮箱服务器邮箱地址（邮箱用户名）
	$mail->Username = 'zgs5999';
	$mail->Password = 'laozhou616888';

	/*内容信息*/
	$mail->isHTML(true);
	$mail->Charset 	= 'utf-8';
	$mail->From 	= 'zgs5999@163.com';
	$mail->FromName = '上海纽珀医院管理';
	$mail->Subject 	= $subject;
	$mail->MsgHTML($msghtml);
	//发送到   地址
	$mail->addAddress($sendTo);

	//发送邮件
	if ( $mail->send() )
	{
		return true;
	} 
	else
	{
		return $mail->ErrorInfo;
	}
}

/**
 * [preventXSS  防止sql注入]
 * @param  [type] $v [description]
 * @return [type]    [处理后的数据]
 */
function preventXSS($v)
{
	return is_array($v) ? array_map('preventXSS',$v) : addslashes($v);
}


/**
 * [preventTags 防止html标签]
 * @param  [type] $v [description]
 * @return [type]    [处理后的数据]
 */
function preventTags($v){

	return is_array($v) ? array_map('preventTags',$v) : htmlspecialchars($v);
	
}


/**
 * [getRandStr 随机字符串]
 * @param  integer $length [长度]
 * @param  integer $type   [类型]
 * @return [type]          [str]
 */
function getRandStr($length = 6,$type = 1 , $encrypt = false )
{
	//判断Type，1. 字母数字混合 2. 纯数字 3. 纯字母
	switch ( $type )
	{
		case 1:
			$str = '0123456789abcdefghijklmnopqrstuvwxyz';
			break;
		case 2:
			$str = '0123456789';
			break;
		case 3:
			$str = 'abcdefghijklmnopqrstuvwxyz';
	}

	//打乱顺序
	$str = str_shuffle($str);

	//根据长度截取,得到原始字符串
	$result = substr($str,0,$length);

	//判断是否加密
	if ( $encrypt )
	{
		return md5(trim($result));
	}
	else
	{
		return trim($result);
	}
}

/**
 * [getTree 无限极分类  树类型]
 * @param  [type]  $arr       [原二维数组]
 * @param  integer $parent_id [起始父ID]
 * @return [type]             [树型数组]
 */
function getTree($arr , $parent_id = 0 , $level = 0)
{
	//定义空数组，储存结果集
	$result = array();

	foreach( $arr as $k => $v)
	{
		if ( $v['parent_id'] == $parent_id )
		{
			//在当前元素基础上，获得子元素
			$c = getTree($arr,$v['id'],$level+1);

			$v['level'] = $level;

			//判断子元素 是否为空  不为空赋给父元素
			if ( $c )
			{
				$v['c'] = $c;
			}

			//把当前元素赋给 结果集 数组
			$result[] = $v;
		}
	}
	//返回结果集
	return $result;
}


/**
 * [getSort 无限极分类  排序型]
 * @param  [type]  $arr       [原二维数组]
 * @param  integer $parent_id [起始 父id]
 * @return [type]             [排序后的数组]
 */
function getSort( $arr , $parent_id = 0 , $level = 0 , $isClean = false)
{

	//定义静态空数组，储存结果集
	static $result = array();

	if( $isClean )
	{
		$result = array();
	}
	
	foreach( $arr as $k => $v)
	{
		if ( $v['parent_id'] == $parent_id )
		{
			$v['level'] = $level;
			//把当前元素赋给 结果集 数组
			$result[] = $v;

			//摧毁当当前
			unset($arr[$k]);

			//在当前元素基础上，获得下级元素
			getSort($arr,$v['id'],$level+1);
		}
	}
	//返回结果集
	return $result;
}
/**
 * [flushMemcache 清空memcache]
 * @return [type] [description]
 */
function flushMemcache()
{
	// //清空此memchchede 权限数据
	// $mem = new \Memcache();
	// $mem->connect('localhost',11211);
	
	// if( $mem->get('pri_'.session('admin_id')) )
	// {
	// 	$mem->delete('pri_'.session('admin_id'));
	// }
}

/**
 * [checkPic 检验上传图片是否合法]
 * @param  [type] $pics [description]
 * @return [type]       [description]
 */
function checkPic($errors)
{
	foreach($errors as $k=>$v)
	{
		if($v === 0)
		{
			return TRUE;
		}
	}
	return FALSE;
}

/**
 * [dealPic 处理图片集]
 * @param  [type] $arr [description]
 * @return [type]      [description]
 */
function dealPic( $arr )
{
	//定义空数组。接收处理后的结果集
	$result = array();

	for($i=0;$i<count($arr['name']);$i++)
	{
		$result[$i]['name'] = $arr['name'][$i];
		$result[$i]['type'] = $arr['type'][$i];
		$result[$i]['tmp_name'] = $arr['tmp_name'][$i];
		$result[$i]['error'] = $arr['error'][$i];
		$result[$i]['size'] = $arr['size'][$i];
	}
	return $result;
}

/**
 * [changeImage description]
 * @param  [type]  $img      [原图片]
 * @param  [type]  $path     [保存路径]
 * @param  [type]  $width    [宽]
 * @param  [type]  $height   [高]
 * @param  [type]  $saveName [保存名称]
 * @param  integer $type     [缩略形式]
 * @return [type]            [保存名称]
 * 应用到  Hospital_add,edit
 */
function changeImage($img,$path,$width,$height,$saveName,$type = 6)
{
	//
	$ext = substr($img,strrpos($img,'.'));

	//实例化 Image 基类
	$image = new \Think\Image();

	//打开图片
	$image->open($img);

	//缩略、
	$image->thumb($width,$height,$type);

	//删除原来的
	@unlink($img);
	
	//保存
	$image->save($path.$saveName);

	return $saveName;
}

/********短信验证码********/

/**
 * [Post curl 模拟post提交]
 * @param [type] $curlPost [参数]
 * @param [type] $url      [目标路径]
 */
function Post($curlPost,$url)
{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}

/**
 * [remove_dir 删除非空文件夹（不是递归）]
 * @param  [type] $rootDir [文件夹路径]
 * @return [type]          [TRUE FALSE]
 */
function remove_dir($rootDir)
{
	$rootDir = trim($rootDir);
	//判断是否是目录
	if( !is_dir($rootDir) )
		return FALSE;

	//打开目录列表
	$list = scandir($rootDir);

	/********禁止删除********/
	array_shift($list);
	array_shift($list);
	/******禁止删除 end******/

	foreach($list as $k => $v)
	{
		if( is_file($item = $rootDir.'/'.$v) )
			@unlink($item) or die('function _ remove_dir is eroor !');;
	}
	$result = rmdir($rootDir) ?  TRUE : FALSE;
	return $result;
}

/**
 * [UnRar 解压 .rar压缩包]
 * @param [type] $filename [压缩包路径]
 * @param [type] $savepath [解压路径]
 * @param [type] $del 	   [是否删除包文件]
 */
function UnRar($filename,$savepath,$del=FALSE)
{
	//转换编码
	$filename = iconv('utf-8','gb2312',$filename);
	//打开rar资源
	$res = rar_open($filename) or die('function _ UnRar 1');
	$list = rar_list($res) or die('function _ UnRar 2');

	$savepath = trim($savepath);
	$pattern = '/\".*\"/';

	foreach($list as $file)
	{
		preg_match($pattern, $file, $matches, PREG_OFFSET_CAPTURE);
		$pathStr=$matches[0][0];
		$pathStr=str_replace("\"",'',$pathStr);
		// echo "<pre>";
		// print_r($pathStr);
		$entry = rar_entry_get($res, $pathStr) or die('function _ UnRar 3');
		$entry->extract($savepath); // extract to the current dir
	}
	rar_close($res); 

	if($del === TRUE)
		@unlink($filename);
}








