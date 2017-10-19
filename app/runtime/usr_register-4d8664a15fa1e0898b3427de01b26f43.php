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
				<span style="color: #fff;">注册</span>
			</div>
			<div class="register form">
				<ul>
					<li style="background-image: url(/style/img/loging_03.png);background-repeat: no-repeat;background-position: 10% center;">
						<input name="telphone" type="tel" placeholder="请输入手机号"/>
					</li>
					<li style="background-image: url(/style/img/loging_07.png);background-repeat: no-repeat;background-position: 10% center;">
						<input name="yzm" type="text" placeholder="请输入验证码"/>
						<button onclick="return model(this,'<?php echo U('yzm/registerSendSMS');?>')">获取验证码</button>
					</li>
					<li style="background-image: url(/style/img/loging_10.png);background-repeat: no-repeat;background-position: 10% center;">
						<input name="password" type="text" onfocus="this.type='password'" placeholder="请输入密码"/>
					</li>
				</ul>
				<a id="regBtn" href="javascript:;" onclick="return model(this,'<?php echo $this->_vars['registerRequest'];?>')">注册</a>
				<div class="password">
					<a href="<?php echo $this->_vars['loginView'];?>" class="fr">已有帐号? 去<span style="color:#46c01b" href="<?php echo $this->_vars['loginView'];?>">登陆</span></a>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script type="text/javascript" src="/public/tools/js/kwjAlert.min.js"></script>
</html>
