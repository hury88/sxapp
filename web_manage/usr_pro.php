<?php
	require './include/common.inc.php';
	require WEB_ROOT.'./include/chkuser.inc.php';
	$table = $showname = 'usr';
	$id = I('get.id', 0 ,'intval');
	if ($id) {$row = M($table)->find($id); extract($row); }
	$opt = new Output;//输出流  输出表单元素
?>
<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="UTF-8" />
	<?php define('IN_PRO',1);include('js/head'); ?>
</head>

<body>


	<div class="content clr">
		<div class="right clr">
			<div class="zhengwen clr">
				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output();Style::submitButton() ?>
						<?php
							Output::select(Config::get('usr_state'), '用户状态','state');
						    $opt
						    ->time('到期时间', 'expired')
						 ?>

<?php include('js/foot'); ?>