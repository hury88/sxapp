<?php include DOCTYPE ?>
<?php include HEAD ?>
<link rel="stylesheet" href="/style/css/jq22.css" type="text/css">
<link rel="stylesheet" type="text/css" href="/style/css/a.style.css.pagespeed.cf.yqgeohotqs.css">
<link rel="stylesheet" type="text/css" href="/style/css/tips.css?v1">
<?php //$obj =  new V($pid,$ty) ?>
<?php $obj =  Showtype::dispatch() ?>

<!-- 中间内容开始-->
<div class="lanrenzhijiaAll">
	<div class="lanrenzhijia">
		<div class="title cf">
			<ul class="title-list fr cf ">

				<?php
					$data = M('news_cats')->field('id,catname')->where(['pid'=>$pid])->order('disorder desc,id asc')->select();
					$li = '';
					$leftArray = [0, 199, 393, 592, 792, 976];
					$leftVal = 0;
					foreach ($data as $key => $value) {
						extract($value);
						$link = $id == $ty ? 'javascript:;' : U($pid, ['ty' => $id]);
						if ($id == $ty) {
							$leftVal = $key;
						}
						$li .= '<a href="'.$link.'"><li>'.$catname.'</li></a>';
					}
					echo $li;unset($li,$data,$key,$value);
				 ?>
				<p style="left:<?php echo $leftArray[$leftVal] ?>px;"><b></b></p>
				<!-- 0 199 393 592 792 976 -->
			</ul>
		</div>
		<div class="product-wrap">
			<!--案例1-->
			<div class="product show">
				<div class="cf" style="width:108%;overflow:hidden">
					<?php echo $obj->display['pc'] ?>

				</div>

			</div>
		</div>
		<?php echo isset($obj->pagestr['pc']) ? $obj->pagestr['pc'] : '' ?>
	</div>
</div>
</div>


<!--sjstart-->
<div class="lanrenzhijiaAllsj">
	<?php echo $obj->display['wap'] ?>
	<?php echo isset($obj->pagestr['wap']) ? $obj->pagestr['wap'] : '' ?>
</div>
<!--sjend-->

<!--中间内容结束-->

<!-- 弹窗 -->
<div class="layer" id="hr_layer"></div>
<div class="tip" id="hr_tip">
	<div class="tiptop">
		<a class="close" id="hr_close"></a>
	</div>
	<?php echo Message::download_form() ?>
</div>

<!-- 手机弹窗 -->
<div class="layer" id="zhezhaoceng"></div>
<div class="tip" id="layer">
	<div class="tiptop" id="closeLayer">
		<a class="close"></a>
	</div>
	<?php echo Message::download_form() ?>
</div>

<script type="text/javascript">

(function(){
	var adds = document.getElementsByClassName("add"),
	tip = document.getElementById("hr_tip"),
	layer = document.getElementById("hr_layer"),
	clo = document.getElementById("hr_close");

	clo.onclick = close;

	len = adds.length;
	for (var i = len - 1; i >= 0; i--) {
		(function(i){
			adds[i].onclick = alertTip;
		})(i)
	};

	function close() {
		tip.style.display = layer.style.display = 'none';
	}

	function alertTip() {
		document.getElementById("saveFileIDInput").value = this.getAttribute("data-id");
		tip.style.display = layer.style.display = 'block';
	}

})();

window.onload = function() {
	var tip = document.getElementById("layer");
	var add = document.getElementsByClassName("madd");
	var clo = document.getElementById("closeLayer");
	var zhezhaoceng = document.getElementById("zhezhaoceng");
	clo.onclick = function(){
		tip.style["display"] = "none";
		zhezhaoceng.style["display"] = "none";
	}
	var length = add.length;
	for(var i = 0; i <= length - 1; i++) {
		(function(e) {
			add[e].onclick = function() {
				zhezhaoceng.style["display"] = tip.style["display"] = "block";

			}
		})(i);
	}
}

</script>
<?php include FOOT ?>
<script src="/style/js/xq_bigimg.js"></script>
