<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ZXZNZ 管理中心</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span1"><a href="#">ZXZNZ 管理员中心</a> </span>
    <span id="search_id" class="action-span1"></span>
    <div style="clear:both"></div>
</h1>
<div class="list-div">
    <table cellspacing='1' cellpadding='3'>
        <tr>
            <th colspan="4" class="group-title">当前管理员信息</th>
        </tr>
        <tr>
            <td width="20%"><a href="#">账号：<?php echo session('admin_name');?></a></td>
            <td width="30%"><strong style="color:red"></strong></td>
            <td width="20%"><a href="#"></a></td>
            <td width="30%"><strong></strong></td>
        </tr>
    </table>
</div>
<!-- end order statistics -->
<br />
<!-- start goods statistics -->
<div class="list-div">
    <table cellspacing='1' cellpadding='3'>

    </table>
</div>
<!-- end order statistics -->
<br />
<!-- start system information -->
<div class="list-div">
    <table cellspacing='1' cellpadding='3'>

    </table>
</div>
<div id="footer">
    ZXZNZ后台管理系统
</div>
</body>
</html>