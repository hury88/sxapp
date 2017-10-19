<!-- 中间内容开始-->
<div class="noticeAll">
	<div id="notice" class="notice">
		<?php innerBanner() ?>
		<div id="notice-con" class="notice-con">
			<!--  对应的菜单栏目  -->
			<div class="mod" style="display:block">
				<div class="twoAll">
					<?php echo config('pcBread')[0] ?>
				</div>
				<div class="honnorXq" style="overflow: hidden;">
					<div class="honnorXq_left">
						<div class="honnor1">
							<img src="<?php echo $view->img1 ?>"/>
						</div>
					</div>
					<div class="honnorXq_right">
						<p><?php echo $view->title ?></p>
						<?php echo $view->content ?>
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
					<div class="honnorXq" style="overflow: hidden;">
						<div class="honnorXq_left">
							<img src="<?php echo $view->img1 ?>"/>
						</div>
						<div class="honnorXq_right">
							<?php echo $view->content ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
