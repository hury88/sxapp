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
		<script type="text/javascript" src="/style/js/jquery.js"></script>
		<style>.subbav{display: none;}</style>
	</head>

	<body>
		<div class="topnav" style="text-align: left;padding-left: 10%;color: #000000;">
			<a href="javascript:window.history.back();" style="padding-top: 1px;"><img src="/style/img/r_03.jpg"  style="margin-top: 16px;height: 28px;"/> </a>
			<span>帮助中心</span>
		</div>
		<div class="container">
			<?php foreach ($this->_vars['items'] as $key=>$row) {@extract($row);?>
			<div class="mainbav">
				<h2>Q<?php echo $key+1;?>、<?php echo $title;?></h2>
				<img src="/style/img/zk7.jpg" class="i1"/>
				<img src="/style/img/zk8.jpg" class="i2" />
				<div class="subbav">
					<?php echo htmlspecialchars_decode($content);?>
				</div>
			</div>
			<?php }?>
			</div>

			<script type="text/javascript" src="/style/js/js.js" ></script>

		</div>

	</body>

</html>