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


<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Privilege/edit/id/18.html" enctype="multipart/form-data" >
    	<input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
				<td class="label">上级权限：</td>
				<td>
					<select name="parent_id">
						<option value="0">顶级权限</option>
                        <?php foreach( $result as $k => $v):?>
                            <option value='<?php echo $v['id'];?>' <?php if( $v['id'] == $info['parent_id'] ){ echo "selected='selected'";}?>> 
                                <?php echo str_repeat('---',$v['level']+1);?> 
                                <?php echo $v['pri_name'];?>
                            </option>
                        <?php endforeach;?>
					</select>
				</td>
			</tr>
            <tr>
                <td class="label">权限名称：</td>
                <td>
                    <input  type="text" name="pri_name" value="<?php echo $info['pri_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">对应的模块名：</td>
                <td>
                    <input  type="text" name="module_name" value="<?php echo $info['module_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">对应的控制器名：</td>
                <td>
                    <input  type="text" name="controller_name" value="<?php echo $info['controller_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">对应的方法名：</td>
                <td>
                    <input  type="text" name="action_name" value="<?php echo $info['action_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="hidden" name="id" value='<?php echo $info['id'];?>'>
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
</script>

<div id="footer"> e美评 后台管理系统</div>
</body>
</html>