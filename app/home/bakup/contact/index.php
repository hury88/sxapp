<?php include DOCTYPE ?>
<?php include HEAD ?>
<!-- 中间内容开始-->
<div class="contacts">
	<div class="contactsAll">
		<div class="contactsTop">
			<?php echo config('pcBread')[0] ?>
		</div>
		<div class="contactsCon">
			<h2><?php echo config('translator.contact_title') ?></h2>
			<?php echo v_news($pid, -$ty, 'content') ?>
			<?php echo Message::form() ?>
		</div>
	</div>
</div>
<!--中间内容结束-->
<?php include FOOT ?>
<?php
	//右侧悬浮进来的
	if (isset($_GET['callback'])) {
		echo <<<EOF
<script>
	$("body,html").stop().animate({scrollTop : $(".contactsAll").height()+$(".banner").height()-$(".contactsBom").height()},1500)
</script>
EOF;
	}
 ?>