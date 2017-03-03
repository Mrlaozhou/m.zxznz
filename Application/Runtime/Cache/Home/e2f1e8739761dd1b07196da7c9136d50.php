<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="/Public/Home/login/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="/Public/Home/login/css/icomoon.css">
	<!-- Themify Icons-->
	<link rel="stylesheet" href="/Public/Home/login/css/themify-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="/Public/Home/login/css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="/Public/Home/login/css/magnific-popup.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="/Public/Home/login/css/owl.carousel.min.css">
	<link rel="stylesheet" href="/Public/Home/login/css/owl.theme.default.min.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="/Public/Home/login/css/style.css">

	<!-- Modernizr JS -->
	<script src="/Public/Home/login/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
		
	<div class="gtco-loader"></div>
	
	<div id="page">

	
	<div class="page-inner">
	<nav class="gtco-nav" role="navigation">
		<div class="gtco-container">
			
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<div id="gtco-logo"><a href="index.html">Splash <em>.</em></a></div>
				</div>
				<div class="col-xs-8 text-right menu-1">
<!-- 					<ul>
						<li><a href="features.html">Features</a></li>
						<li><a href="tour.html">Tour</a></li>
						<li class="has-dropdown">
							<a href="#">Dropdown</a>
							<ul class="dropdown">
								<li><a href="#">Web Design</a></li>
								<li><a href="#">eCommerce</a></li>
								<li><a href="#">Branding</a></li>
								<li><a href="#">API</a></li>
							</ul>
						</li>
						<li><a href="pricing.html">Pricing</a></li>
						<li><a href="contact.html">Contact</a></li>
						<li class="btn-cta"><a href="#"><span>Get started</span></a></li>
					</ul>
 -->				</div>
			</div>
			
		</div>
	</nav>
	
	<header id="gtco-header" class="gtco-cover" role="banner" style="background-image: url(/Public/Home/login/images/img_4.jpg)">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					

					<div class="row row-mt-15em">
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">Hello</span>
							<h1>Welcome to Newborn from Shanghai</h1>	
						</div>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">
									<ul class="tab-menu">
										<li class="active gtco-first"><a href="#" data-tab="signup">注 册</a></li>
										<li class="gtco-second"><a href="#" data-tab="login">登 录</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
											<form action="<?php echo U('index/register');?>">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="username">用户名</label>
														<input type="username" class="form-control" id="username">
													</div>
													<script type="text/javascript">
														$('#username').bind({'blur':function(){
															var username = $('#username').val();
															$.ajax({
																url:"<?php echo U('ajaxCheckUser');?>",
																type:"POST",
																data:{'username':username},
																dataType:'json',
																success:function(data)
																{
																	if( data.result )
																	{
																		$("#")
																	}
																	else
																	{

																	}
																}
															})
														},'focus':function(){

														}})
													</script>
												</div>
												<div class="row form-group">
													<div class="col-md-12" style="position: relative;">
														<label for="password">手机号码</label>
														<input type="text" class="form-control" id="password">
														<input style="position: absolute;top:40px;right:20px;font-size:14px;" type="button" value="点击获取验证码">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="password2">请输入短信验证码</label>
														<input type="text" class="form-control" id="SMS">
													</div>
												</div>

												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" class="btn btn-primary" value="注 册">
													</div>
												</div>
											</form>	
										</div>

										<div class="tab-content-inner" data-content="login">
											<form action="<?php echo U('Index/login');?>" method="post">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="username">用户名</label>
														<input name="username" type="text" class="form-control" id="username">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="password">密 码</label>
														<input name="password" type="password" class="form-control" id="password">
													</div>
												</div>

												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" class="btn btn-primary" value="Login">
													</div>
												</div>
											</form>	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
							
					
				</div>
			</div>
		</div>
	</header>
	</div>

	</div>
	
	<!-- jQuery -->
	<script src="/Public/Home/login/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="/Public/Home/login/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="/Public/Home/login/js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="/Public/Home/login/js/jquery.waypoints.min.js"></script>
	<!-- Carousel -->
	<script src="/Public/Home/login/js/owl.carousel.min.js"></script>
	<!-- countTo -->
	<script src="/Public/Home/login/js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="/Public/Home/login/js/jquery.magnific-popup.min.js"></script>
	<script src="/Public/Home/login/js/magnific-popup-options.js"></script>
	<!-- Main -->
	<script src="/Public/Home/login/js/main.js"></script>

	</body>
</html>