<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - <?php echo $_page_title; ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src='/Public/jquery-1.11.3.min.js'></script>
    <link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!-- 内容 -->


	<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
    
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">活动基本信息</span>
            <span class="tab-back">活动详情</span>
            <!-- <span class="tab-back">活动照片</span> -->
        </p>
    </div>
    <div id="tabbody-div">
	    <form method="post" action="/index.php/Admin/Active/add.html" enctype="multipart/form-data" >
	    	<!-- 基本信息 -->
	        <table class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	            <tr>
	                <td class="label">活动标题</td>
	                <td>
	                    <input type="text" name="title" size="60" maxlength="60" value="" />
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="label">活动地址</td>
	                <td>
						<input type="text" name="location" size="40" />
						<span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	        
	            <tr>
	                <td class="label">活动照片</td>
	                <td>
	                    <input type="file" name="pic" />
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">活动项目</td>
	                <td>
	                    <input type="text" name="object" size='30' />
	                    <span class="require-field">* 请用逗号隔开</span>
	                    <br /><br />
	                </td>
	            </tr>

	            <tr>
	                <td class="label">活动时间</td>
	                <td>
	                	<script language="javascript" type="text/javascript" src="/Public/date/WdatePicker.js"></script>
	                    <input class="Wdate" type="text" name="start_time" onClick="WdatePicker()">
	                     — 
	                    <input class="Wdate" type="text" name="end_time" onClick="WdatePicker()">
	                    <span class="require-field">*</span>          
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否置顶</td>
	                <td>
	                    <input type="radio" name="is_top" value="1" /> 是
	                    <input type="radio" name="is_top" value="0"  checked="checked" /> 否
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否显示</td>
	                <td>
	                    <input type="radio" name="is_show" value="1"  checked="checked" /> 是
	                    <input type="radio" name="is_show" value="0" /> 否
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">状态</td>
	                <td>
	                    <input type="radio" name="status" value="1"   checked="checked"/> 正在进行
	                    <input type="radio" name="status" value="0" /> 即将开始
	                    <br /><br />
	                </td>
	            </tr>
	        </table>
	        <!-- 活动介绍 -->
	        <table style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td><textarea id="intro" name="intro" cols="60" rows="4"  ></textarea></td>
	            </tr>
	        </table>
	        <!-- 活动相册 -->
	        <!--
	        <table id="table_pic_list" style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td><input id="btn_add_pic" type="button" value="添加一张" /></td>
	            </tr>
	            <tr><td><input type="file" name="pic[]" /></td></tr>
	        </table>
	        -->
	        <!-- 提交按钮 -->
	        <table cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td colspan="2" align="center"><br />
	                    <input type="submit" class="button" value=" 确定 " />
	                    <input type="reset" class="button" value=" 重置 " />
	                </td>
	            </tr>
	        </table>
	    </form>
    </div>
</div>

<script>
UM.getEditor('intro', {
	initialFrameWidth : "80%"
});
function addNewExtCat(btn)
{
	// 选择后面的下拉框并克隆一个
	var newSel = $(btn).next("select").clone();
	// 把新的下拉框添加到当前TD的最后
	$(btn).parent().append(newSel);
}
// 为类型绑定change事件
$("select[name=province]").change(function(){
	// 先取出选择的类型ID
	var province = $(this).val();
	province = encodeURI(encodeURI(province));
	var html = '';
	$.ajax({
		type : "GET",
		url : "<?php echo U('ajaxGetCitys', '', FALSE); ?>/province/"+province,
		dataType : "json",
		success : function(data)
		{
			//拼接代码
			$(data).each(function(k,v){
				html += "<option value='"+v+"'>"+v;
				html += "</option>";
			});
			//把代码追加到select[name='city']
			$("select[name=city]").html(html);
		}
	});
});
function onloadAjax()
{
	var province = $("select[name=province]").val();
	province = encodeURI(encodeURI(province));
	var html = '';
	if( province )
	{
		$.ajax({
			type : "GET",
			url : "<?php echo U('ajaxGetCitys', '', FALSE); ?>/province/"+province,
			dataType : "json",
			success : function(data)
			{
				//拼接代码
				$(data).each(function(k,v){
					html += "<option value='"+v+"'>"+v;
					html += "</option>";
				});
				//把代码追加到select[name='city']
				$("select[name=city]").html(html);
			}
		});		
	}
	else
	{
		html = "<option valuse=''>请选择城市</option>";
		//把代码追加到select[name='city']
		$("select[name=city]").html(html);
	}
}
//网页加载完成  调用
onloadAjax();



// +号的事件
function addRow(a)
{
	// 先选中所在的LI标签
	var li = $(a).parent();
	if(li.find('a').html() == '[+]')
	{
		// 克隆一个新的LI
		var newLi = li.clone();
		// 变成-号
		newLi.find('a').html('[-]');
		// 新LI放到LI后面
		li.after(newLi);
	}
	else
		li.remove();
}
$("#tabbar-div p span").click(function(){
	// 获取点击的是第几个
	var i = $(this).index();
	// 先隐藏所有的table
	$(".tab_content").hide();
	// 显示第i个
	$(".tab_content").eq(i).show();
	$(".tab-front").removeClass("tab-front").addClass('tab-back');
	$(this).removeClass("tab-back").addClass('tab-front');
});

$("#btn_add_pic").click(function(){
	$("#table_pic_list").append('<tr><td><input type="file" name="pic[]" /></td></tr>');
});
</script>

















<div id="footer"> ZXZNZ 后台管理系统</div>
</body>
</html>