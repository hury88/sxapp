<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php $showtype=12;?>
<?php $obj =  Showtype::dispatch(); ?>
<div class="noticeAll">
	<div id="notice" class="notice">
		<div id="notice-con" class="notice-con">
			<!--  对应的菜单栏目  -->
			<div class="mod" style="display:block">
				<div class="twoAll">
					<?php echo config('pcBread')[0] ?>
					<?php echo $obj->display ?>
				</div>
				<?php echo isset($obj->pagestr['pc']) ? $obj->pagestr['pc'] : '' ?>
			</div>
		</div>
	</div>
</div>
<!--手机开始-->
<div class="noticeAllconsj">
	<div id="notice" class="notice">
		<div id="notice-con" class="notice-con">
			<!--  对应的菜单栏目  -->
			<div class="mod" style="display:block">
				<div class="twoAll">
					<?php echo config('pcBread')[1] ?>
					<?php echo $obj->display ?>
					<?php echo isset($obj->pagestr['wap']) ? $obj->pagestr['wap'] : '' ?>
				</div>

			</div>
		</div>
	</div>
</div>
<?php include FOOT ?>

<?php /*<?php

  	$view = View::index($id, $controller);
  	include DOCTYPE;
  	include HEAD;
?>
<div class="newsxq">
	<div class="noticeAll">
		<div id="notice" class="notice">
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
	<div class="newsxqEx">
		<h2><?php echo $view->title ?></h2>
	</div>
	<div class="newsxqCon">
		<?php echo $view->content2 ?>
	</div>
</div>
<?php
	include FOOT;
?>
*/
?>
