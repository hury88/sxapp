<?php include DOCTYPE ?>
<?php if ($ty==8): //company profile ?>
<?php elseif ($ty==17): //honor ?>
	<link rel="stylesheet" href="/style/css/jq22.css" type="text/css">
	<script src="/style/js/jquery.min.js"></script>
	<script src="/style/js/jq22.js"></script>
	<link rel="stylesheet" type="text/css" href="/style/css/hover-effects.css">
	<script type="text/javascript">
	$(function(){
		$('.zizhiP a').click(function(){
			var n=$(this).index();
			$('.zizhiP a').removeClass('on').eq(n).addClass('on');
		});
		$('.threeAll ul li.li4').hover(function(){
			$('.advantagehen').css('background','#46a4ec');
		},function(){
			$('.advantagehen').css('background','#186caa');
		})
	})
	</script>
<?php elseif ($ty==18): //advantage
	$x = <<<EOF
	<script src="/style/js/jquery.min.js"></script>
	<script type="text/javascript">
				$(function(){
					$('.zizhiP a').click(function(){
						var n=$(this).index();
						$('.zizhiP a').removeClass('on').eq(n).addClass('on');
					});
					$('.threeAll ul li.li4').hover(function(){
					$('.advantagehen').css('background','#46a4ec');
				  },function(){
				  	$('.advantagehen').css('background','#186caa');
				  });
				  $('.threeAll ul li.li1').hover(function(){
					$('.advantagehen').css('background','#46a4ec');
				  },function(){
				  	$('.advantagehen').css('background','#186caa');
				  });
				   $('.threeAll ul li.li2').hover(function(){
					$('.advantagehen').css('background','#FFED24');
				  },function(){
				  	$('.advantagehen').css('background','#FFED24');
				  });
				  $('.threeAll ul li.li3').hover(function(){
					$('.advantagehen').css('background','#F67144');
				  },function(){
				  	$('.advantagehen').css('background','#F67144');
				  });
				   $('.threeAll ul li.li4').hover(function(){
					$('.advantagehen').css('background','#186CAA');
				  },function(){
				  	$('.advantagehen').css('background','#186CAA');
				  })

				})
			</script>
<ul>
	<li class="li1"><a href=""></a></li>
	<li class="li2"><a href=""></a></li>
	<li class="li3"><a href=""></a></li>
	<li class="li4"><a href=""></a></li>
	<div class="" style="clear: both;">
	</div>
	<div class="advantagehen">According to the characteristics of the global pig farms and technological innovation, it let pigs scientifically is available.</div>
</ul>
EOF;
	$x2 = <<<EOF
	<style>
		.noticeAllconsj .threeAll ul li {height:auto}
		.noticeAllconsj .threeAll ul li img {width: 95%;}
	</style>
<ul style="padding-bottom:45px;">
	<li class="li1"><img src="/style/images/advantage1.jpg"/></li>
	<li class="li2"><img src="/style/images/advantage2.jpg"/></li>
	<li class="li3"><img src="/style/images/advantage3.jpg"/></li>
	<li class="li4"><img src="/style/images/advantage4.jpg"/></li>
	<div class="" style="clear: both;">
	</div>
</ul>
EOF;
?>
<?php elseif ($ty==19): //International cooperation ?>
<?php endif ?>
<?php include HEAD ?>
<?php //$obj =  new V($pid,$ty) ?>
<?php $obj =  Showtype::dispatch() ?>
	<div class="noticeAll">
		<div id="notice" class="notice">
			<?php innerBanner() ?>
			<div id="notice-con" class="notice-con">
				<!--  对应的菜单栏目  -->
				<div class="mod" style="display:block">
					<?php if ($ty==18): //advantage ?> <div class="threeAll"> <?php else: ?> <div class="twoAll"> <?php endif ?>
					<?php echo config('pcBread')[0] ?>
					<?php echo $obj->display ?>
					<?php echo isset($x) ? $x : '' ?>
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
					<?php if ($ty==18): //advantage ?> <div class="threeAll"> <?php else: ?> <div class="twoAll"> <?php endif ?>
						<?php echo config('pcBread')[1] ?>
					<?php echo isset($x2) ? $x2 : '' ?>
					<?php echo $obj->display ?>
					<?php echo isset($obj->pagestr['wap']) ? $obj->pagestr['wap'] : '' ?>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!--手机结束-->
<?php //echo $obj->display ?>
<?php //echo $obj->pagestr ?>

<?php include FOOT ?>