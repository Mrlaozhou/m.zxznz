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
            <span class="tab-front">发布基本信息</span>
            <!-- <span class="tab-back">发布介绍</span> -->
            <!-- <span class="tab-back">活动照片</span> -->
        </p>
    </div>
    <div id="tabbody-div">
	    <form method="post" action="/index.php/Admin/Publish/edit/id/6.html" enctype="multipart/form-data" >
	    	<!-- 基本信息 -->
	        <table class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	            <tr>
	                <td class="label">发布标题</td>
	                <td>
	                    <input type="text" name="title" size="60" maxlength="60" value="<?php echo $info['title'];?>" placeholder="建议言简意赅" />
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">行为</td>
	                <td>
	                    <input type="text" name="action" value="<?php echo $info['action'];?>" />
	                    <span class="require-field">*(英文与数字组合，英文字母开头)</span>
	                    <br /><br />
	                </td>
	            </tr>
	        
	            <tr>
	                <td class="label">上传页面</td>
	                <td>
	                    <input type="file" name="html" />
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>

				<tr>
	                <td class="label"></td>
	                <td>
	                    <img style="width:50px;height:30px;" src="/Public/Uploads/<?php echo $info['bg'];?>">
	                </td>
	            </tr>
	            <tr>
	                <td class="label">上传背景图</td>
	                <td>
	                    <input type="file" name="bg" />
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">上传图片压缩包</td>
	                <td>
	                    <input type="file" name="imgRar" />
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
					<td class="label">背景类型</td>
					<td>
	                    <input type="radio" name="bg_type" value="1" <?php if($info['bg_type'] == '1'){ echo "checked='checked'"; }?> /> 1
	                    <input type="radio" name="bg_type" value="2" <?php if($info['bg_type'] == '2'){ echo "checked='checked'"; }?> /> 2
	                    <input type="radio" name="bg_type" value="3" <?php if($info['bg_type'] == '3'){ echo "checked='checked'"; }?> /> 3
	                    <input type="radio" name="bg_type" value="4" <?php if($info['bg_type'] == '4'){ echo "checked='checked'"; }?> /> 4
	                    &nbsp;&nbsp;&nbsp;
	                    <img style="width:50px;" src="/Public/Admin/Images/bg_type.png">
	                    <br /><br />
	                </td>
				</tr>
	            <tr>
	                <td class="label">时间</td>
	                <td>
	                	<script language="javascript" type="text/javascript" src="/Public/date/WdatePicker.js"></script>
	                    <input class="Wdate" type="text" name="begin" onClick="WdatePicker()" value="<?php echo date("Y-m-d",$info['begin']);?>">
	                    <span class="require-field">*</span>          
	                    <br /><br />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">发布介绍</td>
	                <td>
	                	<textarea name="intro" style="width:400px;height:80px;"><?php echo $info['intro'];?></textarea>
	                    <span class="require-field">*</span>
	                    <br /><br />
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="label">是否显示</td>
	                <td>
	                    <input type="radio" name="is_show" value="1" <?php if($info['is_show'] == 1){ echo "checked='checked'"; }?> /> 是
	                    <input type="radio" name="is_show" value="0" <?php if($info['is_show'] == 0){ echo "checked='checked'"; }?>/> 否
	                    <br /><br />
	                </td>
	            </tr>
	          
	        </table>
	        
	        <!-- 提交按钮 -->
	        <table cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td colspan="2" align="center"><br />
	                    <input type="submit" class="button" value=" 确定 " />
	                    <input type="reset" class="button" value=" 重置 " />
	                    <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
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