<div id="header">
	<div class="w">
		<a href="/" id="logo"><img src="<?php echo $system_logo1 ?>" alt="<?php echo $system_sitename ?>"></a>
		<ul id="nav">
			<li><a <?php echo IS_INDEX  ? 'class="active"' : ''?> href="/">网站首页<small>HOME</small></a></li>
			<li><a <?php echo $pid == 1 ? 'class="active"' : ''?> href="<?php echo U(1) ?>">关于我们<small>ABOUT US</small></a></li>
			<li><a <?php echo $pid == 2 ? 'class="active"' : ''?> href="<?php echo U(2) ?>">新闻中心<small>NEWS</small></a></li>
			<li><a <?php echo $pid == 3 ? 'class="active"' : ''?> href="<?php echo U(3) ?>">影视中心作品<small>MOVIES</small></a></li>
			<li><a <?php echo $pid == 4 ? 'class="active"' : ''?> href="<?php echo U(4) ?>">节目中心作品<small>PROGRAM</small></a></li>
			<li><a <?php echo $pid == 5 ? 'class="active"' : ''?> href="<?php echo U(5) ?>">影视设备<small>EQUIPMENT</small></a></li>
			<li><a <?php echo $pid == 6 ? 'class="active"' : ''?> href="<?php echo U(6) ?>">联系我们<small>CONTACT US</small></a></li>
		</ul>
	</div>
</div>

<?php if (IS_INDEX): ?>
	<div id="banner">
		<ul class="rslides size">
			<?php echo v(7,19,'<li><a style="background-image: url(%src(%$img1%)%);" href="%$linkurl%" target="_blank"></a></li>') ?>
		</ul>
	</div>
<?php elseif(IS_LIST): ?>
	<div class="shadow png_bg"></div>
	<div id="banner" class="min">
		<ul class="rslides size">
			<?php echo v(7,15,'<li><a style="background-image: url(%src(%$img1%)%);" href="%$linkurl%" target="_blank"></a></li>') ?>
		</ul>
	</div>
<?php endif ?>