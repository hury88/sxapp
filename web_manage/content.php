<?php
require './include/common.inc.php';
define('TABLE_NEWS',true);
require WEB_ROOT.'./include/chkuser.inc.php';

$table = 'content';
$showname = 'content';

$find = M('news')->where(array('pid'=>$pid,'ty'=>-$ty,'tty'=>$tty))->find();
@extract($find);
$ty < 0 and $ty = abs($ty);
$opt = new Output;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>单一内容</title>
	<?php define('IN_PRO',1);include('js/head'); ?>
</head>

<body>

	<div class="content clr">
		<div class="weizhi">
			<p>位置：
				<a href="mains.php">首页</a>
				<span>></span>
				<?=$classname?>
			</p>
		</div>
		<div class="right clr">
			<div class="zhengwen clr">
				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output() ?>
						<input type="hidden" name="pid" value="<?=$pid?>" />
						<input type="hidden" name="ty"  value="<?=$ty?>"  />
						<input type="hidden" name="tty" value="<?=$tty?>" />
						<?php
							$opt
							->ifs($ty==30)
							->img('关于我们', 'img1', '961*665')
							->img(v_news_cats(8,'catname'), 'img2', '480*320')
							->img(v_news_cats(17,'catname'), 'img3', '480*320')
							->img(v_news_cats(18,'catname'), 'img4', '480*320')
							->img(v_news_cats(19,'catname'), 'img5', '480*320')
							->editor('关于我们简介','content','90%',100)
							// ->img('配图', 'img1', '772X270')
							// ->img('二维码', 'img1', '772X270')
							// ->img('地图', 'img1', '772X270')
							->endifs()
							->ifs($ty==13)
							->editor('信息内容','content','90%',1000)
							->endifs()
							// ->editor('信息内容','content','90%','600')
							->ifs($ty<>13 && $ty<>30)
							->editor('信息内容','content')
							->endifs()
						;
							define('DEL_TIME_SORT',1);include('js/foot');
						?>