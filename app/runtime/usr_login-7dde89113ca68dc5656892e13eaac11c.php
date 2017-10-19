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
</head>

<body>
	<div class="container">
		<div class="topnav"style="background: #46c01b;">
			<a href="javascript:window.history.back()" style="padding-top: 1px;"><img src="/style/img/return_03.png" height="60" /> </a>
			<span style="color: #fff;">登录</span>
		</div>
		<div class="register form">
			<ul>
				<input type="hidden" name="r" value="<?php echo isset($_GET['r']) ? $_GET['r'] : '' ?>">
				<li style="background-image: url(/style/img/loging_03.png);background-repeat: no-repeat;background-position: 10% center;">
					<input name="telphone" type="tel" placeholder="请输入手机号"/>
				</li>
				<li style="background-image: url(/style/img/loging_10.png);background-repeat: no-repeat;background-position: 10% center;">
					<input name="password" type="text" onfocus="this.type='password'" placeholder="请输入密码"/>
				</li>
			</ul>
			<a id="regBtn" href="javascript:;" onclick="return model(this,'<?php echo $this->_vars['loginRequest'];?>')">登录</a>
			<div class="password">
				<a href="<?php echo $this->_vars['registerView'];?>" class="fl">新用户请注册</a>
				<a href="<?php echo U('lookup');?>" class="fr">忘记密码？</a>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script type="text/javascript" src="/public/tools/js/alert.min.js"></script>
</html>
