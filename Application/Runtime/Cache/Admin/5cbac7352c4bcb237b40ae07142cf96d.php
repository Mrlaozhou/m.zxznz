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
                <th>活动标题</th>
                <th>开始时间</th>
                <th>行为</th>
                <th>发布介绍</th>
                <th>背景</th>
                <th>背景类型</th>
                <th>是否显示</th>
                <th>添加时间</th>
                <th width="200">操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>
            <tr>
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['title'];?></td>
                <td align="center">
                    <?php echo date('Y.m.d',$v['begin']);?>
                    
                </td>
                <td>
                    <?php echo $v['action'];?>
                </td>
                <td>
                    略。。
                </td>
                <td>
                    <img style="width:50px ;height:30px;" src="/Public/Uploads/<?php echo $v['bg'];?>">
                </td>
                <td>
                    <?php echo $v['bg_type'];?>
                </td>
                <td align="center">
                    <?php if($v['is_show'] == 1):?>
                        <span style="color:red;">是</span>
                    <?php else:?>
                        否
                    <?php endif;?>
                </td>
                
                <td align="center">
                    <?php echo date('Y-m-d H:i:s',$v['create_time']);?>
                </td>
                <td align="center"> 
                    <a href="<?php echo U('edit?id='.$v['id']); ?>" title="编辑">编辑</a> |
                    <a onclick="return confirm('确定要删除吗？真的确定吗？');" href="<?php echo U('del?id='.$v['id']); ?>" title="移除">移除</a> 
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td align="right" nowrap="true" colspan="13">
                    <div id="turn-page">
                       <?php echo $page;?>
                        <p style="clean:both;"></p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<div id="footer"> ZXZNZ 后台管理系统</div>
</body>
</html>