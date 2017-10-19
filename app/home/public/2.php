<?php include DOCTYPE ?>
<?php include HEAD ?>
<div id="broadcast">
	<div class="video">
		<embed src="<?php echo $view->linkurl ?>" allowfullscreen="true" quality="high" width="1000" height="520" align="middle" allowscriptaccess="always" type="application/x-shockwave-flash">
	</div>
</div>
<div id="main">
	<div class="videoInfo">
		<h3><?php echo $view->title ?></h3>
		<p class="date">发布日期：<?php echo $view->time ?></p>
	</div>

	<h2 class="rec">相关作品</h2>
	<div class="work">
		<ul>
			<?php echo v($pid,$ty,'<li><a href="__URL__"><img src="%src(%$img1%)%" alt="%$title%" width="214" height="301"></a><p><a href="__URL__">%$title%</a></p></li>',4) ?>
		</ul>
	</div>
</div>

<?php include FOOT ?>

</body>
</html>