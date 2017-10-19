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
		<script type="text/javascript" src="/style/js/jquery.js"></script>
		<style>
			.img2 {
				display: none;
			}
			.img3{
				display: none;
			}
			.shanchu label{padding-left: 0;}
			.carnum{padding-top: 0;}
			.xzz{background: #e4e4e4 !important;}
			.no {position:absolute;top:50%;text-align: center;width: 100%;background: white; font-weight: bold; color: #666;}
		</style>



	</head>

	<body>
		<?php if (!$this->_vars['list']){?>
		<div class="no">
	    	<p>暂无数据，敬请期待！</p>
	    </div>
		<?php } ?>
		<div class="topnav" style="color: #000000;border-bottom: 8px solid #F4F4F4;height: 65px;">
			<a href="javascript:window.history.back()" style="padding-top: 1px;"><img src="/style/img/r_03.jpg" style="margin-top: 16px;height: 25px;" /> </a>
			<span>购物车</span>
			<a href="javasript:edit();" style="left: 85%;line-height: 60px;color: #333;font-size: 0.36rem;">编辑</a>
			<a href="javasript:over();" style="display:none;left: 85%;line-height: 60px;color: #333;font-size: 0.36rem;">完成</a>
		</div>

		<div>
			<?php if ($this->_vars['address']){?>
			<!-- 显示地址 -->
			<a href="<?php echo U('usr/addressList');?>"><div class="carinfo" style="">
				<div class="clr">
					<label class="fl"><?php echo $this->_vars['address']['consigner'];?></label>
					<label class="fr" style="padding-right: 6%;"><?php echo $this->_vars['address']['mobile'];?></label>
				</div>
				<p>收货地址:<?php echo $this->_vars['address']['address'];?></p>
			</div></a>
			<?php }else{?>
			<!-- 新增地址 -->
			<div class="addadress clr" style="margin-bottom:0;border-bottom:10px solid rgb(244, 244, 244)">
				<a href="<?php echo U('usr/addressAdd');?>" class="fl"><img src="/style/img/adr_03.png" />新增收货地址</a>
				<a href="<?php echo U('usr/addressAdd');?>" class="fr"><img src="/style/img/x.png" /></a>
			</div>
			<?php } ?>
			<div class="time">
				<img src="/style/img/time_03.png" style="height: 0.45rem;position: relative;top: 0.3rem;margin-right: 0.1rem;"/>
					配送日期
				<em>（6:00-8:00）</em>
			</div>
			<div style="height: 15px;background: #F4F4F4;"><img src="/style/img/gwc_02.png" /></div>
		</div>

		<div class="carnum">
			<ul>
				<?php foreach ($this->_vars['list'] as $key=>$row) {@extract($row);?>
				<li class="clr">
					<a href="javascript:;" class="xuanzhong fl"><img src="/style/img/gwc_13.png" /><img src="/style/img/gwc_08.png" class="img2" /></a>
					<a href="<?php echo U('goods/view', ['id'=>$id]);?>" class="productimg fl"><img src="<?php echo src($img1);?>" /></a>
					<div class="fr">
						<div>
							<p><?php echo $goods_name;?></p>
							<span><?php echo $goods_name_added;?></span>
						</div>
						<div class="clr add">
							<span class="fl pri">￥<em><?php echo $market_price;?></em><i>/斤</i></span>
							<form class="num_box fr">
								<a class="J_jian">-</a>
								<label><input type="text" class="num" value="<?php echo $num;?>"/></label>
								<a class="J_jia">+</a>
							</form>
						</div>
					</div>
				</li>
				<?php }?>
			</ul>

		</div>
		<div style="height: 2.3rem;background: #f1f2f7;"></div>
		<div class="shanchu">
			<label>
				<a class="shan xuanzhong fl" style="padding-left:.5rem;font-size:0.25rem">
					<img src="/style/img/gwc_13.png" />
					<img src="/style/img/gwc_08.png" class="img3" />
					全选
				</a>
			</label>
			<div class="xiadan">
				<span style="font-weight:bold;">&emsp;合计：<em>￥ <span id="totalpriceshow">0.00</span></em></span>
			</div>
			<a class="fr">去结算<i style="font-size:.2rem">(0)</i></a>
			<!-- <a class="fr">删除</a> -->
		</div>
		<!--底部导航-->
		<div class="foot">
			<a href="<?php echo U('index');?>"><img src="/style/img/nav5.png" /></a>
			<a href="<?php echo U('goods/index');?>"><img src="/style/img/nav_05.png" /></a>
			<a href="<?php echo U('cart');?>"><img src="/style/img/nav7.png" /></a>
			<a href="<?php echo U('usr');?>"><img src="/style/img/nav_09.png" /></a>
		</div>
		<div class="blackbox"></div>
		<div id="time">
			<p class="title">
				<img src="/style/img/1_03.png" />
				中午12点之前可选择当天派送，超过中午12点延迟一天
			</p>
			<div class="fl">
				<ul class="xz">
					<li>今天(周一)</li>
					<li>周二</li>
					<li>周三</li>
					<li>周四</li>
					<li>周五</li>
				</ul>
			</div>
			<div class="fr">
				<ul class="xs">
					<li>6:00-8:00</li>
					<li>9:00-11:00</li>
					<li>12:00-14:00</li>
					<li>15:00-17:00</li>
					<li>18:00-20:00</li>
				</ul>
			</div>
			<div style="clear: both;"></div>
			<div class="btn">取 消</div>
		</div>


	</body>

	<script type="text/javascript" src="/style/js/js.js" ></script>
	<script type="text/javascript" src="/public/tools/js/kwjAlert.min.js" ></script>

	<script>
		function edit() {

		}

		function over() {

		}
	</script>

	<script>
	dialog(1,['测试成功!!',"这是个标题"],{cancel:['haha','http:www.baidu.com']});
	</script>

</html>