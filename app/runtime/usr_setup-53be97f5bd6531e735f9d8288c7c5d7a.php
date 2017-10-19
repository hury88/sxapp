<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8" />
		<title><?php echo $GLOBALS['system_seotitle'];?></title>
		<meta name="keywords" content="<?php echo $GLOBALS['system_keywords'];?>">
		<meta name="description" content="<?php echo $GLOBALS['system_description'];?>">
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<link rel="stylesheet" href="/style/css/style.css" />
		<script type="text/javascript" src="/style/js/rem.js"></script>
		<meta http-equiv ="proma" content = "no-cache"/>
		<meta http-equiv="cache-control" content="no cache" />
		<meta http-equiv="expires" content="0" />
		<script type="text/javascript" src="/style/js/jquery.js"></script>
	</head>

	<body>
		<div class="topnav" style="text-align: left;padding-left: 10%;color: #000000;">
			<a href="javascript:window.history.back()" style="padding-top: 1px;"><img src="/style/img/r_03.jpg" style="margin-top: 16px;height: 25px;" /> </a>
			<span>设置</span>
		</div>
		<div class="container">
			<dl>
				<dd>
					<a href="<?php echo $this->_vars['resetView'];?>"><label>修改密码</label></a>
				</dd>
				<dt style="border-bottom: 1px solid #ccc;height: 0.3rem;border-top: 1px solid #ccc;background-image: none;"></dt>
				<dd id="returnn" style="width: 100%;padding-left: 5%;margin-left: 0;">
					<a href="javascript:;"><label>退出登录</label></a>
				</dd>
			</dl>
		</div>

		<div class="blackbox"></div>
		<div class="clreann" id="clr">
			<div style="border-bottom: 1px solid f5f5f5;">确定要清除缓存吗？</div>
			<div class="clicker clr">
				<a class="return" style="border-right: 1px solid #ebebeb;">取消</a>
				<a href="<?php echo U('usr/clearCache');?>" class="sure">确定</a>
			</div>
		</div>
		<div class="returnn clreann">
			<div style="border-bottom: 1px solid f5f5f5;">确定要退出吗？</div>
			<div class="clicker clr">
				<a class="return" style="border-right: 1px solid #ebebeb;">取消</a>
				<a href="<?php echo U('login/out');?>" class="sure">确定</a>
			</div>
		</div>
		<script type="text/javascript" src="/style/js/js.js" ></script>

	</body>
	<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script type="text/javascript" src="/public/tools/js/alert.min.js"></script>
</html>
