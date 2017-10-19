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
		<div class="topnav" style="color: #000000;border-bottom: 8px solid #F4F4F4;height: 65px;">
			<a href="javascript:window.history.back();" style="padding-top: 1px;"><img src="/style/img/r_03.jpg" style="margin-top: 16px;height: 25px;" /> </a>
			<span>我的订单</span>
		</div>

		<div class="carnum order">
			<ul>
				<?php foreach ($this->_vars['list'] as $key=>$row) {@extract($row);?>
				<a href="<?php echo U('usr/order', ['oid'=>$id]);?>"><div class="oderinfo" style="text-align:left"><span>订单号 : <?php echo $order_no;?></span><span class="fr">查看详情</span></div></a>
				<?php $count = 0; ?>
				<?php foreach(Order::getOrderGoods($id) as $g) { ?>
				<li class="clr">
					<a href="<?php echo U('goods/view', ['id'=>$g['goods_id']]);?>" class="productimg fl"><img src="<?php echo src($g['img1']);?>" /></a>
					<div class="fr">
						<div class="clr">
							<p class="fl"><?php echo $g['goods_name'];?></p>
							<p class="fr">￥<?php echo $g['price'];?></span>
						</div>
						<div class="clr add">
							<span class="fl pri"><?php echo $g['goods_name_added'];?></span>
							<span class="fr pri">x<?php echo $g['num'];?></span>
						</div>
					</div>
				</li>
				<?php $count += $g['num']; ?>
				<?php } ?>
				<div class="oderinfo"><span>共<?php echo $count;?>件商品</span> <span>合计:￥<?php echo $goods_money;?></span></div>
				<?php }?>
			</ul>

		</div>
	</body>
</html>
