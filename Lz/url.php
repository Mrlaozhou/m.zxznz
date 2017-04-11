<?php


$ROUTE = substr(trim($_SERVER['PATH_INFO']),1);


if( !$ROUTE )
	die("路由错误！");

parse_str(str_replace('^','=',strrev(str_rot13(base64_decode(urldecode(trim($ROUTE)))))),$result);


return $result;