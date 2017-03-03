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

<div class="form-div">

</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号（id）</th>
                <th>医院名称</th>
                <th>医院地址</th>
                <th>医院分类</th>
                <th>评分人数</th>
                <th>评分总数</th>
                <th>医院图片</th>
                <th>医院简介</th>
                <th>显示状态</th>
                <th>显示到主页</th>
                <th>操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>
            <tr>
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['name'];?></td>
                <td align="center"><?php echo $v['address'];?></td>
                <td align="center"><?php echo $v['type'];?></td>
                <td align="center"><?php echo $v['score_number'];?></td>
                <td align="center"><?php echo $v['score_total'];?></td>
                <td align="center"><img src='/Public/Uploads/<?php echo $v['logo'];?>' width="30"></td>
                <td align="center">略。。</td>
                <td align="center">
                    <?php if($v['is_show']):?>
                        <span style="color:red;">是</span>
                    <?php else:?>
                        否
                    <?php endif;?>
                </td>
                <td align="center">
                    <?php if($v['is_index']):?>
                        <span style="color:red;">是</span>
                    <?php else:?>
                        否
                    <?php endif;?>
                </td>
                <td align="center">
                    <a href="<?php echo U('Doctor/lst?hos_id='.$v['id']);?>">医生列表</a> | 
                    <a href="<?php echo U('edit?id='.$v['id']); ?>" title="编辑">编辑</a> |
                    <a onclick="return confirm('确定要删除吗？');" href="<?php echo U('del?id='.$v['id']); ?>" title="移除">移除</a> 
                    <a onclick="refreshHosToTop(this);" hosId="<?php echo $v['id'];?>" href="javascript:;" title="移除">刷新置顶</a> 
                </td>
            </tr>
            <?php endforeach; ?>
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

<script type="text/javascript">
function refreshHosToTop(a)
{
    if( window.confirm('点击确定，刷新置顶！') )
    {
        var id = $(a).attr('hosId');
        $.ajax({
            url:"/index.php/Admin/Hospital/ajaxRefreshHosTop/id/"+id,
            type:"GET",
            dataType:'json',
            success:function(data){
                if( data.result )
                {
                    $(a).html("<span style='color:red;'>刷新成功</span>");
                }
                else
                {
                    $(a).html("<span style='color:blue;'>刷新失败</span>");
                }
            }
        })
    }
    else
    {
        
    }
}
</script>

<div id="footer"> ZXZNZ 后台管理系统</div>
</body>
</html>