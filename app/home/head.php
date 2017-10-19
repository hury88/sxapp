<div class="header">
	<div class="logo">
		<a href="/">
			<img src="/style/images/logo.png" class="logo1" alt="<?php echo $system_sitename ?>">
			<img src="<?php echo $system_logo1 ?>" class="logo2" alt="<?php echo $system_sitename ?>">
		</a>
	</div>

	<div class="navwrap">
		<ul class="nav">
			<?php pc_nav() ?>
		</ul>

	</div>

	<div class="navigation">
		<ul class="level-1">
			<?php wap_nav() ?>
		</ul>
	</div>

	<div class="toggle">

		<a class="icon"></a>

	</div>

	<div class="language">

		<a href=""><img src="/style/images/en.png" />EN</a>

		<a href=""><img src="/style/images/ch.png" />中文</a>

	</div>

	<div class="language-phone">

		<a href="">EN</a>

	</div>

</div>


<?php if (IS_INDEX): ?>
	<div class="banner">
		<div class="owl-carousel owl-theme" id="owl-index">
			<?php echo vv(7,15,'<div class="item"> <a href="{{$linkurl}}" target="_blank"> <img class="lazyOwl img-responsive" src="__IMG__"> </a> <div class="text"> <h3>&nbsp;</h3> </div> </div>') ?>
			<?php //echo v(7,15,'<li><a style="background-image: url(%src(%$img1%)%);" href="%$linkurl%" target="_blank"></a></li>') ?>
		</div>
	</div>
<?php else: ?>
	<div class="banner">
		<img src="<?php echo $pid_img1 ?>" style="width: 100%;"/>
	</div>
<?php endif ?>
