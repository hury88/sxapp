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
		.carnum li .add{position: relative;}
		.carnum li .btn{position: absolute;right:0;width: 38%;right: -2%;width:auto;}
		.carnum li .btn button.minus{margin-right:-10px;display:none;}
		.carnum li .btn button{width:40px;height:40px;border:0;background:transparent;padding:0;}
		.carnum li .btn button strong{padding:5px 10px;font-size:15px;display:inline-block;text-indent:-100px;padding:5px 11px;height:12px;}
		.carnum li .btn button.minus strong{background:url(/style/img/down.png) no-repeat;background-size:22px 22px;}
		.carnum li .btn i{line-height: 3.1; display:none;width:22px;text-align:center;font-style:normal;vertical-align:top;margin-top:11px;line-height:18px;}
		.carnum li .btn button.adds{margin-left:-10px;}
		.carnum li .btn button.adds strong{background:url(/style/img/up.png) no-repeat;background-size:22px 22px;}
		.carnum li .btn .price{display:none;}
	</style>
	</head>

	<body style="background: #F4F4F4;">
		<div class="top_menu sub_menu" style="background:rgba(255,255,255,1);">
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

		<div class="carnum pay" style="margin-bottom:1rem">
			<ul>
				<?php foreach ($this->_vars['items'] as $key=>$row) {@extract($row);?>
				<li class="clr">
					<a href="<?php echo U('goods/view', ['id'=>$goods_id]);?>" class="productimg fl"><img src="/style/img/gwc_05.png" /></a>
					<div class="fr">
						<div>
							<p><?php echo $goods_name;?></p>
							<span><?php echo $goods_name_added;?></span>
						</div>
						<div class="clr add">
							<span class="fl pri">￥<em><?php echo $market_price;?></em><i>/斤</i><a><?php echo $price;?><i></i></a></span>
							<div class="btn" data-gid="<?php echo $goods_id;?>">
								<button class="minus"><strong></strong></button>
								<i class="num">0</i>
								<button class="adds"><strong></strong></button>
								<i class="price"><?php echo $market_price;?></i>
							</div>
						</div>
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
		<div class="shanchu shanchu1">
			<label>
				<a class="xuanzhong fl">
					<img src="/style/img/c_03.png" />
				    <span class="snum" id="totalcountshow"><?php echo $this->_vars['cart_goods_count'];?></span>
				</a>
			</label>
			<a href="javascript:CollectGoodsData()" class="fr">加入购物车</a>
			<div class="xiadan fr">
				<span>合计：<em>￥ <span id="totalpriceshow">0.00</span></em></span>
			</div>

		</div>
	</body>
	<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script type="text/javascript" src="/public/tools/js/kwjAlert.min.js"></script>
<script type="text/javascript">
function CollectGoodsData()
{
	var fd = {};
	fd['cart'] = {};
	$(".btn.selected").each(function(i){
		console.log(i);
		var gid = $(this).data("gid");
		var num = $(this).find("i.num").text();
		fd.cart[gid] = num;
	})
	httpPost('<?php echo U('cart/addRequest');?>', fd)
}
$(function () {
	//加的效果
	$(".adds").click(function () {
		$(this).prevAll().css("display", "inline-block");
		var n = $(this).prev().text();
		var num = parseInt(n) + 1;
		if (num == 0) { $(this).parent(".btn").removeClass("selected");return; }
		$(this).parent(".btn").addClass("selected");
		$(this).prev().text(num);
		var danjia = $(this).next().text();//获取单价
		var a = $("#totalpriceshow").html();//获取当前所选总价
		$("#totalpriceshow").html((a * 1 + danjia * 1).toFixed(2));//计算当前所选总价

		var nm = $("#totalcountshow").html();//获取数量
		$("#totalcountshow").html(nm*1+1);
		jss();//<span style='font-family: Arial, Helvetica, sans-serif;'></span>   改变按钮样式
	});
	//减的效果
	$(".minus").click(function () {
		var n = $(this).next().text();
		var num = parseInt(n) - 1;

		$(this).next().text(num);//减1

		var danjia = $(this).nextAll(".price").text();//获取单价
		var a = $("#totalpriceshow").html();//获取当前所选总价
		$("#totalpriceshow").html((a * 1 - danjia * 1).toFixed(2));//计算当前所选总价

		var nm = $("#totalcountshow").html();//获取数量
		$("#totalcountshow").html(nm * 1 - 1);
		//如果数量小于或等于0则隐藏减号和数量
		if (num <= 0) {
			$(this).next().css("display", "none");
			$(this).css("display", "none");
			$(this).parent(".btn").removeClass("selected");
			jss();//改变按钮样式
			 return
		}
	});
	function jss() {
		var m = $("#totalcountshow").html();
		if (m > 0) {
			$(".right").find("a").removeClass("disable");
		} else {
		   $(".right").find("a").addClass("disable");
		}
	};

});
</script>

</html>
