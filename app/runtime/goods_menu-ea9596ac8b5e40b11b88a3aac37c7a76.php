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
		<div class="top_menu sub_menu">
			<div class="home">
				<form action="<?php echo U('goods/items');?>" style="background-color:#f8f8f8;border-radius: 0.4rem;background-image: url(/style/img/ss_03.png);background-repeat: no-repeat;background-size: 9%;background-position: 33% center;display: block;margin: 0 auto;left: 0;width: 86.5%;">
	<input type="submit" value="" style="width: 38%;">
	<input name="q" value="<?php echo $GLOBALS['q'];?>" class="fr" type="text" placeholder="生鲜配送产品" style="width: 3.58rem;">
</form>
				<!-- <form style="background-color:#f8f8f8;border-radius: 0.4rem;background-image: url(/style/img/ss_03.png);background-repeat: no-repeat;background-size: 9%;background-position: 33% center;display: block;margin: 0 auto;left: 0;width: 86.5%;">
					<input type="submit" value="" style="width: 38%;">
					<input class="fr" type="text" placeholder="生鲜配送产品" style="width: 3.58rem;">
				</form> -->
			</div>
		</div>

		<div class="column">
			<ul class="sescond clr">
				<!-- 导航入口 -->
				<?php foreach ($this->_vars['nav'] as $id=>$img1) {@extract($img1);?>
				<li>
					<a href="<?php echo U('goods/submenu', ['category_id_1'=>$id]);?>">
						<img src="<?php echo src($img1);?>" />
					</a>
				</li>
				<?php }?>
			</ul>
		</div>
		<div style="height: 65px;"></div>

		<!--底部导航-->
		<div class="foot">
			<a href="<?php echo U('index');?>"><img src="/style/img/nav5.png" /></a>
			<a href="<?php echo U('goods/index');?>"><img src="/style/img/nav6.png" style="width: 73%;"/></a>
			<a href="<?php echo U('cart');?>"><img src="/style/img/nav_07.png" /></a>
			<a href="<?php echo U('usr');?>"><img src="/style/img/nav_09.png" /></a>
		</div>
	</body>
</html>
