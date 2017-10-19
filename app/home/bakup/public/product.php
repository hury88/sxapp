				<link rel="stylesheet" type="text/css" href="/style/css/tabs-underlined1.css">
				<link rel="stylesheet" type="text/css" href="/style/css/a.style.css.pagespeed.cf.yqgeohotqs.css">
				<script type="text/javascript" src="/style/js/jquery.js"></script>
				<script type="text/javascript" src="/style/js/jquery.jcarousel.min.js"></script>
				<script type="text/javascript" src="/style/js/jcarousel.connected-carousels.js"></script>
				<script type="text/javascript">
				$(function(){
	//设计案例切换
	$('.title-list li').mouseover(function(){
		var liindex = $('.title-list li').index(this);
		$(this).addClass('on1').siblings().removeClass('on1');
		$('.product-wrap div.product').eq(liindex).fadeIn(150).siblings('div.product').hide();
		var liWidth = $('.title-list li').width();
		$('.lanrenzhijia .title-list p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
	});

	//设计案例hover效果
	$('.product-wrap .product li').hover(function(){
		$(this).css("border-color","#ff6600");
		$(this).find('p > a').css('color','#ff6600');
	},function(){
		$(this).css("border-color","#fafafa");
		$(this).find('p > a').css('color','#666666');
	});
});
				</script>
				<div class="noticeAll">
					<div id="notice" class="notice">
						<?php //innerBanner() ?>
						<div id="notice-con" class="notice-con">
							<!--  对应的菜单栏目  -->
							<div class="mod" style="display:block">
								<div class="twoAll">
									<?php echo config('pcBread')[0] ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- 中间内容开始-->
				<div class="chanpingxq">
					<div class="chanpingxqAll">
						<div class="wrapper">
							<div class="connected-carousels">
								<div class="stage">
									<div class="carousel carousel-stage">
										<ul>
											<?php
											$data = v_list('pic', 'img1', ['ti' => $view->id]);
											echo v_data($data, '<li><img src="%src(%$img1%)%" width="600" height="400" alt=""></li>');
											?>
										</ul>
									</div>
								</div>
								<div class="navigation">
									<div class="carousel carousel-navigation">
										<ul>
											<?php echo v_data($data, '<li><img src="%src(%$img1%)%" width="50" height="50" alt=""></li>'); ?>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="chanpingxqRight">
							<div class="dchanpingall" style="padding-top: 0;">
								<div class="dchanpingLeft">
									Summary:
								</div>
								<div class="dchanpingRight">
									<?php echo $view->ftitle ?>
								</div>
							</div>
							<div class="dchanpingall">
								<div class="dchanpingLeft1">
									Selling price
								</div>
								<div class="dchanpingRight1">
									<p class="no">
										<?php echo $view->price ?>
									</p>
									<p>
										<img src="/style/images/chanpingxqicon.jpg"/>
										Consulting customer service
									</p>
								</div>
							</div>
							<div class="dchanpingall">
								<div class="dchanpingLeft2">
									Product introduction
								</div>
								<div class="dchanpingRight2">
									<?php echo $view->introduce ?>
								</div>
							</div>
							<form action="<?php echo $view->source ?>" target="_blank"><input type="submit" name="" id="" value="<?php echo config('tips.buyBtn') ?>" class="dbtn"/></form>
						</div>


					</div>

					<!-- 特效开始-->
					<div class="lanrenzhijia">
						<div class="title cf">
							<ul class="title-list fr cf ">
								<li class="on1">Specifications</li>
								<li>Accessories</li>
								<li>Advantages</li>
								<p><b></b></p>
							</ul>
						</div>
						<div class="product-wrap">
							<!--案例1-->
							<div class="product show">
								<?php echo $view->content ?>
							</div>
							<!--案例2-->
							<div class="product" style="display: none;">
								<?php echo $view->content2 ?>
							</div>
							<!--案例3-->
							<div class="product" style="display: none;">
								<?php echo $view->content3 ?>
							</div>
						</div>
					</div>


					<!-- 手机端开始-->
					<div class="tabs-underline">

						<ul>
							<li>
								<a class="tab-active" data-index="0">First tab</a>
							</li>
							<li>
								<a data-index="1">Second tab</a>
							</li>
							<li>
								<a data-index="2">Third tab</a>
							</li>
						</ul>

						<div class="tabs-content-placeholder">

							<div>
								<?php echo $view->content ?>

							</div>

							<div class="tab-content-active">
								<?php echo $view->content2 ?>

							</div>

							<div>
								<?php echo $view->content3 ?>

							</div>

						</div>

					</div>
					<!-- 手机端结束-->
					<!--特效结束-->
					<div class="newlb" style="padding-bottom: 20px;">
						<!--pc开始-->
						<?php include HOME . 'public' .DS. 'bottom' .EXT ?>
					</div>
					<!--中间内容结束-->
					<!--<script src="js/jquery.min.js"></script>-->
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
