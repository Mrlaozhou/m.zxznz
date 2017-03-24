<?php
	function template_head($title,$cssList,$jsList)
	{
?>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
		<meta name="full-screen" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="screen-orientation" content="portrait">
		<meta name="browsermode" content="application">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<meta name="x5-orientation" content="portrait">
		<meta name="x5-fullscreen" content="true">
		<meta name="x5-page-mode" content="app">
		<title><?php echo $title;?></title>
		<link rel="stylesheet" href="/Html/style/global.css">
<?php
		foreach($cssList as $i => $css)
		{
?>
		<link rel="stylesheet" href="/Html/style/<?php echo $css;?>">
<?php
		}
?>	
		<script src="/Html/js/jquery-1.11.3.min.js"></script>
		<script src="http://libs.baidu.com/jqueryui/1.8.22/jquery-ui.min.js "></script>

<?php
		foreach($jsList as $i => $js)
		{
?>
		<script src="/Html/js/<?php echo $js;?>"></script>
<?php
		}
?>
		<script>
			$('html').attr('style','font-size:'+$(window).width()/10+'px');
		</script>
	</head>

<?php
	}
?>