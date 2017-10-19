<script type="text/javascript" src="/style/js/jquery.js"></script>
<script type="text/javascript" src="/style/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="/style/js/jcarousel.connected-carousels.js"></script>
<!-- 中间内容开始-->
<div class="noticeAll">
	<div id="notice" class="notice">
		<?php //innerBanner() ?>
		<div id="notice-con" class="notice-con">
			<!--  对应的菜单栏目  -->
			<div class="mod" style="display:block">
				<div class="twoAll">
					<?php echo config('pcBread')[0] ?>
				</div>
				<div class="fourAll">
					<div class="inter1">
						<div class="wrapper" style="padding-right: 0;">
							<div class="connected-carousels">
								<div class="stage">
									<div class="carousel carousel-stage" style="height: 383px;">
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

						<div class="inter1_right">
							<h2><?php echo $view->title ?></h2>
							<?php echo $view->content ?>
						</div>

						<div class="clear"> </div>
						<p class="dintertit"><?php //echo config('translator.CooperationProcess') ?></p>
						<ul class="dinter">
							<?php
							$data = v_list('news', 'title,ftitle,content', ['istop' => $view->id]);
							echo v_data($data, '<li> <div class="all10"> <p class="year">%$title%</p> <p class="month">%$ftitle%</p> </div> <div class="all11"> %$content% </div> </li>');
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 手机模式开始-->

<div class="noticeAllsj">
	<div id="notice" class="notice">
		<div id="notice-con" class="notice-con">
			<!--  对应的菜单栏目  -->
			<div class="mod" style="display:block">
				<div class="twoAll">
					<?php echo config('pcBread')[1] ?>
				</div>
				<div class="fourAll">
					<div class="inter1">
						<div class="inter1_left">
							<img src="<?php echo $view->img1 ?>"/>
						</div>

						<div class="inter1_right">
							<h2><?php echo $view->title ?></h2>
							<?php echo $view->content ?>
						</div>

						<div class="clear"> </div>
						<p class="dintertit"><?php echo config('translator.CooperationProcess') ?></p>
						<ul class="dinter">
							<?php
							$data = v_list('news', 'content', ['istop' => $view->id]);
							echo v_data($data, '<p>%$content%</p>');
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
