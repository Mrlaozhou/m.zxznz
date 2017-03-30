<?php

/**
 * [M 实例化模型]
 * @param [type] $table [description]
 */
function M($table)
{
	return new Model(trim($table));
}
/**
 * [dump 打印]
 * @param  [type]  $config [description]
 * @param  integer $type   [description]
 * @return [type]          [description]
 */
function dump($config,$type=1)
{
	echo '<pre>';

	if($type === 1)
		var_dump($config);
	else
		print_r($config);

	exit;
}

/**
 * [Error 报错]
 * @param [type] $msg [description]
 */
function Error($msg)
{
	echo "<h1 style='font-family:楷体;color:#C40000;'>{$msg}</h1>";
	exit;
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
		return md5(trim($result));
	else
		return trim($result);
}

function XSS($config)
{
	return is_array($config) ? array_map('XSS',$config) : htmlspecialchars($config);
}

function SQL($config)
{
	return is_array($config) ? array_map('SQL',$config) : addcslashes($config);
}

function echoJson($config)
{
	exit(json_encode($config));
}

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

function Unsign($param)
{
	$pattern = '/((?=[\x21-\x7e]+)[^A-Za-z0-9])/';
	$result = preg_match($pattern,$param);
	if( $result === 0 )
		return TRUE;
	return FALSE;
}
/*******************************/
function U($config,$type=1)
{
	if($type === 1)
		echo "index.php?a=".$config;
	else
		echo "index.php?c=".$config;
}

function G($config=null)
{
	if( $config )
		return $_GET["{$config}"];
	return $_GET;
}
function P($config)
{
	if( $config )
		return $_POST["{$config}"];
	return $_POST;
}

function A($route)
{
	return 'index.php?u='.$route;
}

function S($k,$v=FALSE,$t=null)
{
	//取值
	if( $v === FALSE )
		return $_SESSION[$k];
	//毁值
	if( $v === null )
		unset($_SESSION[$k]);
	//设值
	$_SESSION[trim($k)] = trim($v);
	return TRUE;
}