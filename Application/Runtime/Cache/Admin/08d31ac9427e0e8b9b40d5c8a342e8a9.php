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

<form method="post" action="/index.php/Admin/Sponsor/lst" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>ID</th>
                <th>医院Id</th>
                <th>医生姓名</th>
                <th>医生照片</th>
                <th>职务</th>
                <th>编号</th>
                <th>擅长技术</th>
                <th>显示状态</th>
                <th>操作</th>
            </tr>
		<?php foreach($infos as $k => $v):?>
    		<tr>
                <td><?php echo $v['id'];?></td>
                <td><?php echo $v['hos_id'];?></td>
                <td><?php echo $v['name'];?></td>
                <td><img src="/Public/Uploads/<?php echo $v['picture'];?>" width="50"></td>
                <td><?php echo $v['duty'];?></td>
                <td><?php echo $v['number'];?></td>
                <td><?php echo $v['good'];?></td>
                <td>
                    <?php if($v['is_show']):?>
                        是
                    <?php else:?>
                        否
                    <?php endif;?>
                </td>
                <td>
                	<input type="button" onclick="ajaxDelDoctor(this)" did="<?php echo $v['id'];?>" value="删除"> | 
                	<a href="<?php echo U('edit?id='.$v['id']);?>">修改</a>
                </td>
            </tr>
		<?php endforeach;?>
            <tr>
                <td align="right" nowrap="true" colspan="9">
                    <div id="turn-page">
                       <?php echo $page;?>
                        <p style="clean:both;"></p>
                    </div>
                </td>
            </tr>
        </table>
    </div>   
</form>

<script>
function addTr(btn)
{
	var tr = $(btn).parent().parent();
	if($(btn).val() == '+')
	{
		var newTr = tr.clone();
		newTr.find(":button").val('-');
		$("table").append(newTr);
	}
	else
		tr.remove();
}

function ajaxDelDoctor(ipt)
{
    if( window.confirm("你确定要删除？") )
    {
        var id = $(ipt).attr('did');
        $.ajax({
            url:"/index.php/Admin/Doctor/ajaxDelDoctor/id/"+id,
            type:"GET",
            dataType:'json',
            success:function(data)
            {
                if( data.result == 1 )
                {
                    alert("删除成功！");
                    $(ipt).parent().parent().remove();
                }
                else
                {
                    alert("删除失败！");
                }
            }
        });
    }
}
</script>

<div id="footer"> ZXZNZ 后台管理系统</div>
</body>
</html>