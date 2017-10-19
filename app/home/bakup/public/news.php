<div class="newsxq">
	<div class="noticeAll">
		<div id="notice" class="notice">
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
	<div class="newsxqEx">
		<h2><?php echo $view->title ?></h2>
		<p>
			<span><img src="/style/images/newsIcon.jpg"/><i><?php echo $view->entime ?></i></span>
			<span><img src="/style/images/newrw.jpg"/><?php echo $view->name ?></span>
			<span>Share to <i class='shares'><div class="addthis_inline_share_toolbox_28w8"></div></i></span>
		</p>
	</div>
	<div class="newsxqCon">
		<?php echo $view->content ?>
		<div class="plast">
			<div class="newup">
				<div class="story1" style="font-weight: normal;"><a href=""><img src="/style/images/newup.jpg"/><span>PREVIOUS STORY</span></a></div>
				<div class="story2"> <?php echo $view->previous ?></div>
			</div>
			<div class="newnext">
				<div class="story1" style="font-weight: normal;"><a href=""><span>NEXT STORY</span><img src="/style/images/newnext.jpg"/> </a></div>
				<div class="story2"><?php echo $view->next ?></div>
			</div>
			<div class="clear">

			</div>
		</div>
	</div>

		<div class="newlb">
			<?php include HOME . 'public' .DS. 'bottom' .EXT ?>
		</div>

</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-595b07393de8e46a"></script>
