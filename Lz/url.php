<?php

count( $url = parse_url( $_SERVER['REQUEST_URI'] ) ) > 1 ? parse_str( $url['query'],$config ) : '';

if( !$config )
	die("路由错误！");

parse_str(str_replace('^','=',strrev(str_rot13(base64_decode(urldecode(trim($config['u'])))))),$result);

return $result;