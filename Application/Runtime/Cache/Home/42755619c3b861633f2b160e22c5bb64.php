<?php if (!defined('THINK_PATH')) exit(); require_once('/Public/Home/header.html');?>



<style type="text/css">
.hos_doc-lb{
	width:100%;
	height:300px;
	position: relative;
}

.hos-doc-left{
	position: absolute;
	top:110px;
	left:0;
}

.hos-doc-right{
	position: absolute;
	top:110px;
	right:0;
}

.hos_img:hover{
	cursor:pointer;
	box-shadow:1px 1px 5px 5px #BBBBBB;
}

/*************hos_cmt*************/

.hos_cmt{
	margin-top:40px;
	width:100%;

	border-top:2px solid #aaaaaa;

}
.hos_cmt_zan{
	padding:30px 0;
}
#heat{
	cursor: pointer;
}
.hos_cmt_box{
	padding-top:20px;
	width:100%;
}
.hos_cmt_box-l{
	width:50px;
	height:50px;
}
.hos_cmt_box-r{
	width:580px;

	background-image:url(/Public/Home/images/hos_cmt_box-r.jpg); 
	background-repeat: no-repeat; 
}
.hos_cmt_list{
	width:570px;
	margin:0 0 0 10px;
}
.hos_cmt_list li{
	width:100%;
	padding-top:50px;
	border-top:1px solid #ccc;
}

#hos_comment{
	cursor:pointer;
}

.hos_reply_box{
	width:100%;
	height:200px;
	display:none;
}
.hos_reply_box-l{
	width:30px;
	height:30px;
}

.hos_reply_box-r{
	width:469px;
	height:100px;
	background-image:url(/Public/Home/images/hos_reply_box-r.jpg);
}
.hos_reply_list{
	width:510px;


}
.hos_reply_list li{
	padding-top:30px;
	border-top:1px solid #ccc;	
}
.hos_reply_controller{
	cursor: pointer;
}
.hos_reply{
	cursor: pointer;
}
</style>




<div class="h-d-content">
	<div class="h-d-top">
		<div><img style="width:100%;height:230px;" src="/Public/Home/images/h-bg.jpg"></div>
		
	</div>
	<div class="h-d-box">
		<div class=" floatL left">
			<div class="hos_img">
				<img style="width:300px;height:300px;" src="/Public/Uploads/<?php echo $info['logo'];?>">
			</div>
		</div>
		<div class="floatR right" style="margin-bottom:30px;">
			<div style="height:234px;">
				<img src="/Public/Home/images/hos_detial.jpg">
			</div>
			<div>
				<p style="height:120px;line-height:120px;color:black;font-size:24px;font-weight:bold;">
					<?php echo $info['name'];?>
				</p>
				<p>
					  <?php echo htmlspecialchars_decode($info['intro']);?>
				</p>				
			</div>

			<!--pinglun-->
			<!--pinglun-->
			<!--pinglun-->

			<div class="hos_cmt">
				<div class="hos_cmt_zan">
					<div style="text-align:center;">
						<p style="margin:20px 0 10px 0;color:#333333;">将文本分享到</p>
						<p style="width:100%;height:32px;">
							<div style="width:100%;" class="bshare-custom icon-medium-plus">
								<div class="bsPromo bsPromo2"></div>
								<a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a>
								<a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a>
								<a title="分享到QQ空间" class="bshare-qzone"></a>
								<a title="分享到新浪微博" class="bshare-sinaminiblog"></a>
								<a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a>
								<span class="BSHARE_COUNT bshare-share-count" style="float: none;">51K</span>
							</div>
							<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=3&amp;lang=zh"></script>
							<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
						</p>

					</div>
				</div>
			</div>

			<ul>
				<li class="floatL" style="font-size:18px;">评论</li>
				<li class="floatR"><a href="javascript:;" style="color:#666666;">
					<?php if( session('user_id') ):?>
						<?php echo session('user_name');?>
					<?php else:?>
						用户登录
					<?php endif;?>
					</a></li>
				<p class="clear"></p>
			</ul>

			<div class="hos_cmt_box">
				<div class="hos_cmt_box-l floatL">
					<img style="width:50px;height:50px;" src="/Public/Home/images/smallhead.png">
				</div>
				<div class="hos_cmt_box-r floatR">
					<textarea style="width:540px;height:80px;margin:10px auto;display:block;border:none;" name="">
						
					</textarea>
					<div style="margin-left:10px;width:570px;height:70px;padding-top:10px;">
						<div id="hos_comment" class="floatR" style="width:30px;height:30px;color:white;font-size:18px;text-align:center;line-height:30px;margin-right:10px;">
							<img style="width:30px;height:30px;" src="/Public/Home/images/talk.png">
						</div>
						<div class="floatR" style="width:50px;height:30px;margin-right:30px;text-align:center;line-height:30px;">
							<span class="floatL" style="height:30px;line-height:30px;">
								<img style="width:30px;height:30px;" id="heat" status="0" hos_id="<?php echo $info['id'];?>" src="/Public/Home/images/heat-yes2.png" alt="">
							</span>
							<span class="floatR" style="display:inline-block;font-size:16px;color:black;" id="like"><?php echo $info['like'];?></span>
							<span class="clear"></span>
						</div>
	<!---->
	<script type="text/javascript">
		$("#hos_comment").click(function(){
			var val = $(this).parent().parent().find('textarea').val();
			if( val )
			{
				$.ajax({
					url:"<?php echo U('Hcomment/ajaxHosComment');?>",
					type:"POST",
					data:{"content":val,"hos_id":<?php echo $info['id'];?>},
					dataType:"json",
					success:function(data)
					{
						if( data.result )
						{
							var html = "";
							html += "<li cmt_id='"+data.info.id+"' style='width:100%;padding-top:50px;border-top:1px solid #ccc;'>";
							html +=	"	<div class='floatL' style='width:30px;height:30px;background:#ccc;'>";
							html +=	"       <img style='width:30px;height:30px;' src='/Public/Home/images/smallhead.png'>";
							html +=	"	</div>";
							html +=	"	<div class='floatR' style='width:510px;'>";
							html +=	"       	<p style='font-size:16px;'>"+data.info.user_name+"</p>";
							html +=	"           <p style='color:#666666;padding:5px 0 20px 0;border-bottom:1px dashed #bbb;'>";
							html +=					data.info.content;
							html +=	"           </p>";
							html +=	"           <div style='width:100%;height:50px;line-height:50px;'>";
							html +=	"               <span class='floatL'>"+data.info.time+"</span>";
							html += "               <span class='hos_reply_controller floatR' index='0' class='floatR' onclick='showBox(this);'>回复</span>";
							html += "               <span class='clear'></span>";
							html += "           </div>";
							html += "           <div class='hos_reply_box'>";
							html += "           	<div class='hos_reply_box'>";
							html += "           		<div class='hos_reply_box-l floatL'> </div>";
							html += "           		<div class='hos_reply_box-r floatR'>";
							html += "           			<textarea style='width:429px;height:80px;margin:10px auto;display:block;border:none;'></textarea>";
							html += "           			<div style='width:469px;height:40px;padding:10px 0 30px 0;'>";
							html += "                       	<p onclick='replyThis(this)' cmt_id='"+data.info.id+"' class='floatR' style='width:40px;height:40pxfont-size:18px;color:white;text-align:center;line-height:40px;'>";
							html += "                       		<img style='width:30px;height:30px;' id='heat' status='0' hos_id='<?php echo $info['id'];?>'' src='/Public/Home/images/talk.png' alt=''>";
							html += "                       	</p>";
							html += "                       	<p class='clear'></p>";
							html += "                       </div>";

							html += "                   </div>";
							html += "                   <p class='clear'></p>";
							html += "                </div>";
							html += "            </div>";
							html +=	"   		<ul class='hos_reply_list'>";
							html +=	"   		</ul>";
							html += "   </div>";
							html += "   <p class='clear'></p>";
							html +=	"</li>";

							alert("评论成功！");
							$('.hos_cmt_list').prepend(html);							
						}
						else
						{
							alert(data.info);
						}
					}
				})
			}
			else
			{
				alert("评论内容不能为空！");
			}
		})
	</script>
						<p class="clear"></p>
					</div>
					<!--评论列表-->
					<ul class="hos_cmt_list">
					<!---------->
					<?php foreach($pl as $k => $v):?>
						<li>
							<div class="floatL" style="width:30px;height:30px;">
								<img style="width:30px;height:30px;" src="/Public/Home/images/smallhead.png">
							</div>
							<div class="floatR" style="width:510px;">
								<p style="font-size:16px;"> <?php echo $v['user_name'];?> </p>
								<p style="color:#666666;padding:5px 0 20px 0;border-bottom:1px dashed #bbb;">
									<!--content-->
									<?php echo $v['content'];?>
								</p>
								<div style="width:100%;height:50px;line-height:50px;">
									<span class="floatL"><?php echo date('Y/m/d H:i:s',$v['time']);?></span>
									<span class="hos_reply_controller floatR" onclick="showBox(this);" index="0" class="floatR">回复</span>
									<span class="clear"></span>
								</div>
								<!--reply-box-->
								<div >
									<div class="hos_reply_box" >
										<div class="hos_reply_box-l floatL"> 
											<img style="width:30px;height:30px;" src="/Public/Home/images/smallhead.png">
										</div>
										<div class="hos_reply_box-r floatR">
											<textarea style="width:429px;height:80px;margin:10px auto;display:block;border:none;"></textarea>
											<div style="width:469px;height:40px;padding:10px 0 30px 0;">
												<p cmt_id="<?php echo $v['id'];?>" class="hos_reply floatR" onclick="replyThis(this)" style="width:40px;height:40px;font-size:18px;color:white;text-align:center;line-height:40px;">
													<img style="width:30px;height:30px;" id="heat" status="0" hos_id="<?php echo $info['id'];?>" src="/Public/Home/images/talk.png" alt="">
												</p>
												<p class="clear"></p>
	<script type="text/javascript">
		function replyThis(r)
		{
			var cmtId = $(r).attr('cmt_id');
			var val = $(r).parent().parent().find('textarea').val();
			if( val )
			{
				$.ajax({
					url:"<?php echo U('Hreply/ajaxHosReply');?>",
					type:"POST",
					data:{"content":val,"cmt_id":cmtId,"hos_id":<?php echo $info['id'];?>},
					dataType:"json",
					success:function(data)
					{
						if( data.result )
						{
							var html = "";
							html += "<li>";
							html += "	<div class='floatL' style='width:30px;height:30px;background:#ccc;'>";
							html +=	"       <img style='width:30px;height:30px;' src='/Public/Home/images/smallhead.png'>";
							html += "	</div>";
							html += "	<div class='floatR' style='width:449px;height:100px;'>";
							html += "		<div style='font-size:16px;height:30px;line-height:30px;'>";
							html += "			<p class='floatL' style='width:100px;'>"+data.info.user_name+"</p>";
							html += "			<p class='floatR' style='width:120px;font-size:12px;'>"+data.info.time+"</p>";
							html += "			<p class='clear'></p>";
							html += "		</div>";
							html += "		<p style='color:#666666;padding:5px 0 20px 0;border-bottom:1px dashed #bbb;'>";
							html += 			data.info.content;
							html += "		</p>";
							html += "	</div>";
							html += "<p class='clear'></p>";
							html += "</li>";

							alert("回复成功！");
							$(r).parent().parent().parent().parent().find('ul').prepend(html);			
						}
						else
						{
							alert(data.info);
						}
					}
				})
			}
			else
			{
				alert('回复内容不能为空！');
			}
		}
	</script>
											</div>
										</div>
										<p class="clear"></p>
									</div>
									<!--hos_reply_list-->
									<ul class="hos_reply_list">
									<!-------------->
									<?php foreach($v['hf'] as $kk => $vv):?>
										<li>
											<div class="floatL" style="width:30px;height:30px;background:#ccc;"></div>
											<div class="floatR" style="width:449px;height:100px;">
												<div style="font-size:16px;height:30px;line-height:30px;">
													<p class="floatL" style="width:100px;"><?php echo $vv['user_name'];?></p>
													<p class="floatR" style="width:120px;font-size:12px;"><?php echo date('Y/m/d H:i:s',$vv['time']);?></p>
													<p class="clear"></p>
												</div>
												<p style="color:#666666;padding:5px 0 20px 0;border-bottom:1px dashed #bbb;">
													<?php echo $vv['content'];?>
												</p>
											</div>
											<p class="clear"></p>
										</li>
									<?php endforeach;?>
									<!-------------->
									</ul>
								</div>
								
							</div>

							<p class="clear"></p>
						</li>

					<?php endforeach;?>
					<!---------------->
					</ul>
				</div>
				<p class="clear"></p>
			</div>

			
		</div>
		<div class="clear"></div>
	</div>

</div>

<script type="text/javascript">

function showBox(c){
	var index = $(c).attr('index');

	if( index == 0 )
	{
		$(c).parent().parent().find('[class=hos_reply_box]').css("display","block");
		$(c).text('关闭');
		$(c).attr('index','1');
	}
	else
	{
		$(c).parent().parent().find('[class=hos_reply_box]').css("display","none");
		$(c).text('回复');
		$(c).attr('index','0');
	}
}
</script>
<!--点赞 js-->
<script type="text/javascript">
	$(function(){
		$("#heat").bind({"mouseover":function(){
			$(this).attr("src","/Public/Home/images/heat-no2.png");
		},"mouseout":function(){
			$(this).attr("src","/Public/Home/images/heat-yes2.png");
		},"click":function(){
			var s = $(this).attr('status');
			if( s == 0 )
			{
				$.ajax({
					url:"<?php echo U('ajaxLikeHos?id='.$info['id']);?>",
					type:"GET",
					dataType:"json",
					success:function(data){
						if( data.result )
						{
							$("#like").text(data.like);
							$("#heat").attr('status','1');
							$("#heat").attr("src","/Public/Home/images/heat-no2.png");
						}
						else
						{
							alert(data.info);
						}
					}
				})
			}
		}});
	})
	
</script>










<?php require_once('/Public/Home/footer.html');?>