<?php if (!defined('THINK_PATH')) exit(); require_once('/Public/Home/header.html');?>

<style type="text/css">
.z-d-content{
	width:100%;

	margin:0 0 50px 0;
	
}

.z-d-top{
	width:100%;
	height:230px;
}
.z-d-box{
	width:1000px;
	margin:50px auto ;
}
.z-d-box .left{
	width:30%;
	height:300px;
}
.z-d-box .left:hover{
	cursor:pointer;
	box-shadow:1px 1px 5px 5px #BBBBBB;
}

.z-d-box .right{
	width:64%;
	color:#777777;
}
.docInfo label{
	color:#111;
}
</style>


<div class="z-d">
	<div class="z-d-top">
		<img style="width:100%;height:230px;" src="/Public/Home/images/z-bg.jpg">
	</div>
	<div class="z-d-box">
		<div class=" floatL left">
			<!-- <img src="/Public/Home/images/hos-3.jpg"> -->
			<img style="width:300px;height:300px;" src="/Public/Uploads/<?php echo $info['picture'];?>">
		</div>
		<div class="floatR right">
			<div style="height:234px;">
				<img src="/Public/Home/images/dos_detial.jpg">
			</div>
			<div class="docInfo">

				<p class="" style="font-size:30px;color:black;padding:30px 0;"><b>基本信息</b></p>
					<ul>
						<li><label>名称：</label><span><?php echo $info['name'];?></span></li>
						<li><label>性别：</label><span><?php echo $info['sex'];?></span></li>
						<li><label>所属医院：</label><span><?php echo $info['hos_name'];?></span></li>
						<li><label>职务：</label><span><?php echo $info['duty'];?></span></li>
						<li><label>职称：</label><span><?php echo $info['title'];?></span></li>
						<li><label>学历：</label><span><?php echo $info['edu'];?></span></li>
					</ul>
				<p class="" style="font-size:30px;color:black;padding:30px 0;"><b>职业信息</b></p>
						<li><label>擅长项目：</label><span><?php echo $info['good'];?></span></li>
						<li><label>从业时间：</label><span><?php echo $info['start'];?></span></li>
						<li><label>医生介绍：</label><span><?php echo htmlspecialchars_decode($info['intro']);?></span></li>
						<li>
							<label>职业经历：</label><span>
										<?php foreach(explode('-----',$info['pass']) as $k => $v):?>
												<?php echo '<br />'.$v;?>
										<?php endforeach;?>
													 </span>
						</li>
				<p class="" style="font-size:30px;color:black;padding:30px 0;"><b>医院介绍</b></p>
				
						<?php echo htmlspecialchars_decode($info['hos_intro']);?>
					
			</div>

		</div>
		<div class="clear"></div>
	</div>
</div>






<?php require_once('/Public/Home/footer.html');?>