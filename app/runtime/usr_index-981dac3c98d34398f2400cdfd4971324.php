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

	<body style="background: #F4F4F4;">
		<div class="center">

			<div style="background: url(<?php echo $this->_vars['bgImage'];?>);background-repeat: no-repeat;">
				<div class="top clr">
					<a href="javascript:window.history.back()" class="fl"><img src="/style/img/cent_06.png"/></a>
					<a href="<?php echo $this->_vars['setupView'];?>" class="fr"><img src="/style/img/cent_03.png"/></a>
				</div>
				<div class="my-info">
					<a href="<?php echo U('usr/myinfo');?>"><span><img src="<?php echo $this->_vars['headImage'];?>"/></span></a>
					<label><?php echo $this->_vars['userName'];?></label>
				</div>
				<div class="bottom clr" style="background-image: url(/style/img/cent_11.png);background-repeat: no-repeat;background-position: center;">
					<a>我的收藏</a>
					<a href="<?php echo U('usr/need');?>">新品需求</a>
				</div>
			</div>
			<div class="info">
				<ul>
					<li>
						<a href="<?php echo U('usr/order');?>">
							<span><img src="/style/img/cent_15.png"/></span>
							<label>全部订单</label>
							<span class="fr"><?php echo $this->_vars['order_count'];?>个&emsp;</span>
						</a>
					</li>
					<li>
						<a href="<?php echo U('usr/faqs');?>">
							<span><img src="/style/img/cent_18.png"/></span>
							<label>常见问题</label>
							<span class="fr"><?php echo $this->_vars['faqs_count'];?>条&emsp;</span>
						</a>
					</li>
					<li style="background-image: none;">
						<a href="tel:<?php echo $GLOBALS['system_phone'];?>">
							<span><img src="/style/img/cent_20.png"/></span>
							<label>客服电话 </label>
							<em><?php echo $GLOBALS['system_phone'];?></em>
						</a>
					</li>
					<li style="background-image: none;">
						<a target="_blank" href="<?php echo $GLOBALS['qq_online'];?>">
							<span><img src="/style/img/cen_03.png"/></span>
							<label>在线客服</label>
							<em>QQ:<?php echo $GLOBALS['system_webqq'];?></em>
						</a>
					</li>
				</ul>
			</div>
		</div>


		<!--底部导航-->
		<div class="foot">
			<a href="<?php echo U('index');?>"><img src="/style/img/nav5.png" /></a>
			<a href="<?php echo U('goods/index');?>"><img src="/style/img/nav_05.png" /></a>
			<a href="<?php echo U('cart');?>"><img src="/style/img/nav_07.png" /></a>
			<a href="<?php echo U('usr');?>"><img src="/style/img/nav08.png" /></a>
		</div>
	</body>
	<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script type="text/javascript" src="/public/tools/js/kwjAlert.min.js"></script>
</html>
