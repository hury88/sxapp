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
		<script type="text/javascript" src="/style/js/jquery.js" ></script>

	</head>

	<body>
		<div class="topnav" style="text-align: left;padding-left: 10%;color: #000000;">
			<a href="javascript:window.history.back()" style="padding-top: 1px;"><img src="/style/img/r_03.jpg" style="margin-top: 16px;height: 25px;" /> </a>
			<span>个人信息</span>
		</div>
		<form class="container myinfo">
			<dl>
				<dd class="inputpic">
					<label>头像：</label>
					<span id="imageViewBox" class="fr"><img src="<?php echo $this->_vars['headImage'];?>" height="42" style="position: relative;top: 0.18rem;"/></span>
				</dd>
				<dd class="inputpic2">
					<label>背景图：</label>
					<span id="imageViewBox2" class="fr"><img src="<?php echo $this->_vars['bgImage'];?>" height="42" style="position: relative;top: 0.18rem;"/></span>
				</dd>
				<dd class="inputname">
					<label>昵称：</label>
					<span class="fr"><?php echo $this->_vars['nickname'];?></span>
				</dd>
				<dd class="redio">
					<label>性别：</label>
					<span class="fr"><?php echo $this->_vars['genderInfo'];?></span>
				</dd>
				<dd>
					<label>手机号：</label>
					<span class="fr"><?php echo $this->_vars['mobileInfo'];?></span>
				</dd>
				<dd >
					<label>收货地址：</label>
					<span class="fr">修改/添加</span>
				</dd>
			</dl>
		</form>

		<div class="blackbox"></div>
	<div class="form">
		<form id="inputname"  class="clreann" style="top: 35%;" onsubmit="return false;">
			<div style="border-bottom: 1px solid f5f5f5 !important;">填写昵称</div>
			<input id="nickname" type="text" name="nickname" value="<?php echo $this->_vars['nickname'];?>" />
			<a onclick="document.getElementById('nickname').value=''" class="qk"><img src="/style/img/QK_03.png"/></a>
			<div class="clicker clr">
				<input type="reset"  class="return" value="取消"/>
				<input onclick="model(this, '<?php echo $this->_vars['myHeadImageRequest'];?>')" type="submit" class="sure" value="确认"/>
			</div>
		</form>

		<form id="inputsex" class="clreann">
			<input id="gender" type="hidden" name="gender" value="<?php echo $this->_vars['gender'];?>">
			<div style="border-bottom: 1px solid f5f5f5 !important;">选择性别</div>

			<div class="clicker clr">
				<a href="javascript:;" onclick="document.getElementById('gender').value=1;document.getElementById('genderWindowClose').click();model(this, '<?php echo $this->_vars['myHeadImageRequest'];?>')" class="fl"><img src="/style/img/sex_03.png"/></a>
				<a href="javascript:;" onclick="document.getElementById('gender').value=2;document.getElementById('genderWindowClose').click();model(this, '<?php echo $this->_vars['myHeadImageRequest'];?>')" class="fr"><img src="/style/img/sex_06.png"/></a>
			</div>

			<a id="genderWindowClose" href="javascript:;" class="qdig">关闭</a>
		</form>

		<form id="inputpic" class="clreann">
			<!-- <div style="border-bottom: 1px solid f5f5f5 !important;">
				<a><img src="/style/img/inf_10.png" width="30"/></a>拍照
			</div> -->
			<div style="border-bottom: 1px solid f5f5f5 !important;position:relative">
				<input style="opacity:0;position:absolute;width: 100%; height: 100%;" onchange="previewImage(this,'imageViewBox','imageView')" name="headimg" type="file" class="filer" />
				<a><img src="/style/img/info_15.png" width="30"/></a>上传头像
			</div>
		</form>
		<!-- 上传背景图 -->
		<form id="inputpic2" class="clreann">
			<div style="border-bottom: 1px solid f5f5f5 !important;position:relative">
				<input style="opacity:0;position:absolute;width: 100%; height: 100%;" onchange="previewImage(this,'imageViewBox2','imageView2')" name="bgimg" type="file" class="filer" />
				<a><img src="/style/img/info_15.png" width="30"/></a>上传背景
			</div>
		</form>
	</div>
		<script type="text/javascript" src="/style/js/js.js" ></script>
	</body>

	<script>
		//图片上传预览    IE是用了滤镜。
		function previewImage(file,id,mid)
		{
			var div = document.getElementById(id);
			if (file.files && file.files[0])
			{
				div.innerHTML ='<img id='+mid+' height="42" style="position: relative;top: 0.18rem;">';

				var img = document.getElementById(mid);
				var reader = new FileReader();
				reader.onload = function(evt){
					src = evt.target.result
					img.src = src;
				}
				reader.readAsDataURL(file.files[0]);
			}
			$("#inputpic").hide();
			$(".blackbox").hide();
			model(file, '<?php echo $this->_vars['myHeadImageRequest'];?>')
		}
	</script>
	<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script type="text/javascript" src="/public/tools/js/kwjAlert.min.js"></script>
</html>
