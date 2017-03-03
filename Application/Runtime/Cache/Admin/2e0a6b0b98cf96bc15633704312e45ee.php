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


<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >账号</th>
            <th >角色信息</th>
			<th width="200">操作</th>
        </tr>
         <?php foreach( $data as $k => $v ):?>
			<tr class="tron">
				<td><?php echo $v['username']; ?></td>
				<td><?php echo $v['role_names']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id']);?>" title="编辑">编辑</a> |
	                <a href="javascript:void(0)" adminid='<?php echo $v['id'];?>' onclick="del(this)" title="移除">移除</a> 
		        </td>
	        </tr>
		<?php endforeach;?>
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
function del(a)
{
	var adminid = $(a).attr('adminid');
	if ( window.confirm('您确定要删除吗？') )
	{
		$.ajax({
			type:'GET',
			url:"/index.php/Admin/Admin/del/id/"+adminid,
			dataType:'json',
			success:function(msg)
			{
				if( msg.result == 1 ) 
				{
					alert('删除成功！');
					$(a).parent().parent().remove();
				}
				else
				{
					alert('删除失败！');
				}
			}
		})
	}
}
</script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>

<div id="footer"> ZXZNZ 后台管理系统</div>
</body>
</html>