<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php //$obj =  new V($pid,$ty) ?>
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
<style>
	.solutious ul .solutiousbg{
	    width: 50px;
	    height: 50px;
	    border-radius: 50%;
	    position: absolute;
	    left: 184px;
	    top: -26px;
	    background: url(../images/solutious3.png) no-repeat center -10px;
	}
</style>

<!-- 中间内容开始-->
    <div class="chanping" id="container">
	    <ul class="masonry">
	    	<?php echo $obj->display ?>
	    </ul>
    	<ul id="jsBtn">
	    	<?php echo $obj->pagestr ?>
    	</ul>
	    <div class="clear"></div>
    </div>

<style>
	.load {text-align: center; height: 50px; padding-top: 20px; position: relative; }
	.load a{text-align: center; color: rgb(153, 153, 153); font-weight: bold; background-color: rgb(216, 216, 216); font-size: 14px; padding: 5px 20px; border-radius: 5px; }
	/*.load span {position: absolute; right: 20%; font-size: 14px; top: 20px;}*/
</style>

<!--中间内容结束-->
<?php include FOOT ?>
	<script src="/style/js/masonry/masonry.pkgd.min.js"></script>
	<script src="/style/js/masonry/controller.js"></script>
	<script>
		$(".chanpingliall").hover(function(){
			that = $(this).children("img")
			tabImg = that.data("img");
			that.attr("src",tabImg);
		},function(){
			tabImg = that.data("img2");
			that.attr("src",tabImg);
		})
		var hury = document.querySelector('#container');
		var container = hury.querySelector('.masonry');
		// var button = document.querySelector('#jsGetMore');
		var msnry = new Masonry( container, {
		  columnWidth: 0
		});

		var productMasonryResult = function(data) {
			elem = data.html
			$("#jsBtn").html(data.btn)
			if (elem) {
				var eles = [];
				for (var i = 0; i <= elem.length-1; i++) {
					elemDom = $(elem[i]).get(0);
				  	container.appendChild( elemDom );
					eles.push(elemDom);
				};
		    	msnry.appended( eles );
			}
		}
		function giveMeMore(page) {
			var url = "/ModelJsonp/request/?page="+page+"&pid=<?php echo $pid ?>&callback=productMasonryResult";
			var script = document.createElement("script");
			script.setAttribute("src", url);
			document.getElementsByTagName("head")[0].appendChild(script);
		}
	</script>