<?php if(!defined('IN_CORP')) exit('Access Denied'); checktplrefresh('/var/www/wj/corpms/templates/default/admin//default.htm', 1299050294); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="templates/default/css/style.css" type="text/css" />
<script src="./fckeditor/fckeditor.js" type="text/javascript"></script>
<!-- fancybox required file start-->
<script src="./js/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="./fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<link rel="stylesheet" href="./fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!-- fancybox required file end-->
<script src="./js/common.js" type="text/javascript"></script>
<!-- include ajax start-->
<script src="./js/ajax.js" type="text/javascript"></script>
<!-- include ajax end-->
<title>网站后台管理</title>
<!-- fancybox 调用jQuery start -->
<script type="text/javascript">
$(document).ready(function() {

/* This is basic - uses default settings */

$("a#single_image").fancybox();

/* Using custom settings */

$("a#inline").fancybox({
'hideOnContentClick': true
});

/* Apply fancybox to multiple items */

$("a.group").fancybox({
'transitionIn'	:	'elastic',
'transitionOut'	:	'elastic',
'speedIn'		:	600, 
'speedOut'		:	200, 
'overlayShow'	:	false
});

$("a.pro_des").fancybox();

$("a.show_info").fancybox();

$("a.inline").fancybox();

});
</script>
<!-- fancybox 调用jQuery end -->
</head>

<body>
<div class="head"><h1 class="left"><span id="site-title">后台</span></h1> 
<div class="right">
<a href="cp.php?ac=home"><?php echo $username; ?></a> | <a href="cp.php?ac=home" title="退出">退出</a>
</div>
</div>
<ul class="admin_menu">
<li id="center" class="menu"><a href="admincp.php">控制中心</a></li>
<li class="menu-separator"><a class="separator" href="?unfoldmenu=1"><br /></a></li> 
<li id="urecommend" class="menu"><a href="admincp.php?ac=corpora">社团管理</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=user">会员管理</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">上传资料</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">查看留言</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">近期公告</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">学生信息导入</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">一人多社团管理</a></li>
<?php if($gid == 4) { ?>
<li id = "urecommend" class="menu"><a href="admincp.php?ac=addcorptype">社团分类</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">管理员管理</a></li>
<li id="urecommend" class="menu"><a href="admincp.php?ac=corporation">系统日志</a></li>
<?php } ?>
<div class="footer">Copyright &copy; 2011<br />All Rights Reserved</div>
</ul>
