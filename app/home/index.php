<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php innerBanner() ?>
<?php echo ::index() ?>
<?php //$obj =  new V($pid,$ty) ?>
<?php $obj =  Showtype::dispatch() ?>
<?php elseif ($ty==11): //水产冻货 ?>
<?php elseif ($ty==14): //粮油 ?>
<?php elseif ($ty==10): //肉禽蛋类 ?>
<?php elseif ($ty==4): //蔬菜 ?>
<?php elseif ($ty==9): //蔬菜 ?>
<?php elseif ($ty==13): //调味料 ?>
<?php elseif ($ty==12): //豆制品 ?>
<?php endif ?>
	<ul>
		<?php echo $obj->display ?>
	</ul>
	<ul>
		<?php echo $obj->pagestr ?>
	</ul>
<?php include FOOT ?>