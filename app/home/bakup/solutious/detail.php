<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php if (isset($view)): ?>
	<?php include HOME . 'public' .DS. 'situation' .EXT ?>
<?php else: ?>
	<?php $showtype=11; ?>
	<?php $obj =  Showtype::dispatch() ?>
		<div class="noticeAll">
			<div id="notice" class="notice">
				<?php //innerBanner() ?>
				<div id="notice-con" class="notice-con">
					<!--  对应的菜单栏目  -->
					<div class="mod" style="display:block">
						<div class="twoAll">
							<?php echo config('pcBread')[0] ?>
						</div>
						<?php echo $obj->display ?>
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
						</div>
						<?php echo $obj->display ?>
						<?php echo isset($obj->pagestr['wap']) ? $obj->pagestr['wap'] : '' ?>
					</div>
				</div>
			</div>
		</div>
		<!--手机结束-->

<?php endif ?>
<?php include FOOT ?>