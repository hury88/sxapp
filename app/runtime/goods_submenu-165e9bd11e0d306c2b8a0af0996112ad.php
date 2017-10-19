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
	<style>
		.column ul li{text-align: center;}
		.column ul li a p{text-align: center;color: #666666;font-size: 0.3rem;height: 0.8rem;line-height: 0.5rem;}
		.no {position:absolute;top:50%;text-align: center;width: 100%;background: white; font-weight: bold; color: #666;}
	</style>
	</head>

	<body>
		<?php if (!$this->_vars['subnav']){?>
		<div class="no">
	    	<p>暂无数据，敬请期待！</p>
	    </div>
		<?php } ?>
		<div class="top_menu sub_menu">
			<div class="home">
				<a href="javascript:window.history.back()" class="fl">
	<img src="/style/img/r_03.jpg" >
</a>
				<form action="<?php echo U('goods/items');?>" style="background-color:#f8f8f8;border-radius: 0.4rem;background-image: url(/style/img/ss_03.png);background-repeat: no-repeat;background-size: 9%;background-position: 33% center;display: block;margin: 0 auto;left: 0;width: 86.5%;">
	<input type="submit" value="" style="width: 38%;">
	<input name="q" value="<?php echo $GLOBALS['q'];?>" class="fr" type="text" placeholder="生鲜配送产品" style="width: 3.58rem;">
</form>
			</div>
		</div>

		<div class="column">
			<ul class="clr">
				<?php foreach ($this->_vars['subnav'] as $id=>$img1) {@extract($img1);?>
				<li>
					<a href="<?php echo U('goods/items', ['category_id_2'=>$id]);?>">
						<img src="<?php echo src($img1);?>" />
						<p><?php echo $title;?></p>
					</a>
				</li>
				<?php }?>
			</ul>
		</div>
		<!--底部导航-->
		<div class="foot">
			<a href="<?php echo U('index');?>"><img src="/style/img/nav5.png" /></a>
			<a href="<?php echo U('goods/index');?>"><img src="/style/img/nav6.png" style="width: 73%;"/></a>
			<a href="<?php echo U('cart');?>"><img src="/style/img/nav_07.png" /></a>
			<a href="<?php echo U('usr');?>"><img src="/style/img/nav_09.png" /></a>
		</div>
	</body>
</html>
