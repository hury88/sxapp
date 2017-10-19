<?php include DOCTYPE ?>
<link rel="stylesheet" href="/style/css/buttons.css">
<link rel="stylesheet" href="/style/css/jquery.carousel.css">
<link rel="stylesheet" href="/style/css/jquery.fancybox.css">
<link rel="stylesheet" href="/style/css/jq22.css" type="text/css">
<link rel="stylesheet" href="/style/css/tabs-underlined.css">
<script src="/style/js/jquery.min.js"></script>
<script src="/style/js/jq22.js"></script>
<style type="text/css">
*{margin:0;
	padding:0;
	list-style:none;
	font-size:12px;}

	.notice1 {
		width: 100%;
		background: #fff;
	}
	.notice1-tit li{float:left;
		width:25%;
		/* line-height:26px;*/
		text-align:center;
		overflow:hidden;
		background:#FFF;
		background:#F7F7F7;
		border-bottom:1px solid #eee;}
		.notice1-tit ul li img{
			width: 100%;
		}
		.notice1-con .mod ul .list1 img{
			width: 96%;
			display: block;
			margin: 0 auto;
		}
		@media (max-width: 1199px) {
			.notice1-con .mod ul .list1 img{
				width: 90%;
				display: block;
				margin: 0 auto;
				padding-top: 25px;
			}
		}
		.notice1-con .mod ul .list2 div{
			padding: 60px 30px;
			width: 70%;

		}
		.notice1-con .mod ul .list2 div p{
			text-align: center;
		}
		.notice1-con .mod ul .list2 div p:nth-child(2){
			font-size: 30px;
			color: #000000;
		}
		.notice1-con .mod ul .list2 div p:nth-child(4){
			font-size:43px;
			color: #333333;
			font-weight: bold;
			padding: 20px 0;
		}
		.notice1-con .mod ul .list2 div p:nth-child(5),
		.notice1-con .mod ul .list2 div p:nth-child(6),
		.notice1-con .mod ul .list2 div p:nth-child(7),
		.notice1-con .mod ul .list2 div p:nth-child(8){
			color: #878787;
			font-size: 14px;
			padding-bottom: 5px;
		}
		.notice1-con .mod ul .list2 div p:nth-child(9){
			padding-top: 40px;
			padding-bottom: 10px;
		}
		.notice1-tit li.select1{background:red;
			padding:0;
			font-weight:bolder;
		}

		.notice1 li a:link,.notice1 li a:visited{text-decoration:none;
			color:#000;}

			.notice1 li a:hover{color:#F90;}


			.notice1-con .mod ul li{float:left;
				width: 50%;
				overflow:hidden;
			}

			@media (max-width: 1199px) {
				.notice1-con .mod ul .list2 div{
					padding: 10px 3px;
					width: 95%;
				}

				.notice1-con .mod ul .list2 div p:nth-child(1) img{
					width: 16%;
				}
				.notice1-con .mod ul .list2 div p:nth-child(4) {
					font-size:12px;
					color: #333333;
					font-weight: bold;
					padding: 5px 0;
				}
				.notice1-con .mod ul .list2 div p:nth-child(2) {
					font-size:12px;
					color: #000000;
				}
				.notice1-con .mod ul li {
					width: 100%;
					overflow: hidden;
				}
				.notice1-con .mod ul .list2 div p:nth-child(9) {
					padding-top: 10px;
					padding-bottom: 3px;
				}
				.notice1{
					width: 100%;
				}
			}
			.notice1-tit ul li:hover{
				background: url(/style/images/view33.jpg) no-repeat;
				background-size: 100% 100%;
			}

			</style>
			<?php include HEAD ?>
			<?php $index = new Index; ?>

			<!--我们的产品开始-->
			<div class="products">
				<div class="products_tit">
					<p><img src="/style/images/products.png" /></p>
					<p>OUR PRODUCTS</p>
					<p><img src="/style/images/productline.png" /></p>
				</div>
				<!-- 特效开始-->
				<div class="lanrenzhijia">
					<?php $index->chanpin_pc(6) ?>
				</div>
				<!--手机端-->
				<div class="tabs-underline">
					<?php $index->chanpin_wap(3) ?>
				</div>
				<!--特效结束-->
			</div>
			<!--我们的产品结束-->

			<!--view开始-->
			<div id="notice1" class="notice1">
				<div id="notice1-con" class="notice1-con">

					<!--  对应的菜单栏目  -->
					<div class="mod">
						<ul>
							<li class="list1">
								<img src="<?php echo $index->__about__leftImg ?>" width="100%"/>
							</li>
							<li class="list2">
								<div>
									<p><img src="/style/images/viewrenwu.jpg"/></p>
									<p>ABOUT US</p>
									<p><img src="/style/images/viewline.jpg"/></p>
									<p>Advantage</p>
									<?php echo $index->__about__rightIntro ?>
									<p><a href="<?php echo $index->__about__ ?>"><img src="/style/images/more.png"/></a></p>
									<?php /*<p><img src="/style/images/newPic.jpg"/></p>*/ ?>
								</div>
							</li>
							<div style="clear: both;">
							</div>
						</ul>
					</div>
					<div class="" style="clear: both;">

					</div>
				</div>
				<div id="notice1-tit" class="notice1-tit" style="overflow: hidden;width: 98%;margin: 0 auto;margin-top: -26px;">
					<ul>
						<li class="select1">
							<a href="<?php $index->__about_u1 ?>"><img src="<?php $index->__about_column1 ?>"/></a>
						</li>
						<li>
							<a href="<?php $index->__about_u2 ?>"><img src="<?php $index->__about_column2 ?>"/></a>
						</li>
						<li>
							<a href="<?php $index->__about_u3 ?>"><img src="<?php $index->__about_column3 ?>"/></a>
						</li>
						<li>
							<a href="<?php $index->__about_u4 ?>"><img src="<?php $index->__about_column4 ?>"/></a>
						</li>
					</ul>

				</div>
				<div class="clear">

				</div>
			</div>
			<!--view结束-->

			<!--slutious开始-->
			<div class="slutious">
				<div class="slutiousTit">
					<p><img src="/style/images/deng.jpg"/></p>
					<p>SLUTIOUS</p>
					<p><img src="/style/images/productline.png"/></p>
				</div>
				<div class="slutiousCon">
					<ul>

						<?php echo $index->slutious() ?>
					</ul>
					<div class="" style="clear: both;">

					</div>
				</div>
			</div>
			<!--slutious结束-->

			<!-- new开始-->
			<div class="new">
				<div class="slutiousTit">
					<p><img src="/style/images/new.jpg"/></p>
					<p>NEWS</p>
					<p><img src="/style/images/newline.jpg"/></p>
				</div>
				<div class="newCon" style="overflow: hidden;">
					<ul>
						<?php echo $index->news() ?>
					</ul>
					<p style="text-align: center;"><a href="<?php $index->__news__ ?>"><img src="/style/images/newMore.jpg"/></a></p>
				</div>
			</div>
			<!-- new结束-->
			<!-- 底部开始-->
			<?php include FOOT ?>
			<script>window.jQuery || document.write('<script src="/style/js/jquery-1.11.0.min.js"><\/script>')</script>
			<script>

			$(document).ready(function() {

				var widget = $('.tabs-underline');

				var tabs = widget.find('ul a'),
				content = widget.find('.tabs-content-placeholder > div');

				tabs.on('click', function (e) {

					e.preventDefault();

			// Get the data-index attribute, and show the matching content div

			var index = $(this).data('index');

			tabs.removeClass('tab-active');
			content.removeClass('tab-content-active');

			$(this).addClass('tab-active');
			content.eq(index).addClass('tab-content-active');

		});

			});

			</script>