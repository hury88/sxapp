<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php //$obj =  new V($pid,$ty) ?>
<?php $obj =  Showtype::dispatch() ?>
<?php if ($ty==12): //NEWS ?>
<?php elseif ($ty==20): //NEWS ?>
<?php endif ?>

<div class="noticeAll">
	<div id="notice" class="notice">
		<?php innerBanner() ?>
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

<div class="noticeAllconsj">
	<div id="notice" class="notice">
		<div id="notice-con" class="notice-con">
			<!--  对应的菜单栏目  -->
			<div class="mod" style="display:block">
				<div class="twoAll">
					<?php echo config('pcBread')[1] ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--手机结束-->


<div class="news">
	<?php echo $obj->display ?>
	<?php echo isset($obj->pagestr['pc']) ? $obj->pagestr['pc'] : '' ?>
	<?php echo isset($obj->pagestr['wap']) ? $obj->pagestr['wap'] : '' ?>
</div>

<?php include FOOT ?>
