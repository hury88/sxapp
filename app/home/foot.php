	<!-- 底部开始-->
	<div class="foot">
		<div class="footAll">
			<ul>
				<li>
					<p>News letter</p>
					<p><a href="">Enter your email address to subscribe our notification</a></p>
					<p><a href="">of our new post & features by email.</a></p>
					<?php echo Message::index_form() ?>
				</li>
				<li>
					<p>About Us</p>
					<?php echo erji_nav(1) ?>
				</li>
				<li>
					<p>PRODUCTS</p>
					<?php echo erji_nav(2) ?>
				</li>
				<li>
					<p>SOLUTIONS</p>
					<?php echo erji_nav(3) ?>
				</li>
				<li>
					<p>OTHERS</p>
					<p><a href="/">Home</a></p>
					<p><a href="<?php echo U(5) ?>">News</a></p>
					<p><a href="<?php echo U(4) ?>">Downloade</a></p>
					<p><a href="<?php echo U(6) ?>">Contact</a></p>
				</li>
			</ul>
			<div class="" style="clear:both;">

			</div>
			<div class="footAll1">
				<?php echo $system_copyright ?>
				<?php echo $system_header ?>
			</div>
		</div>
	</div>
	<!--底部结束-->
	<!-- 固定部分开始  -->
	<div class="online">
		<a class="online-1" href="javascript:oopen('<?php echo $qq_online ?>')"target="_blank"></a>
		<a class="online-2" onclick="SkypeWebControl.SDK.Chat.startChat({ConversationType: 'person', ConversationId: '<?php echo $system_link1 ?>'});" target="_blank"></a>
		<!-- <a class="online-2" id="shouji" href="mqqwpa://im/chat?chat_type=wpa&uin=351427404&version=1&src_type=web&web_src=oicqzone.com" target="_blank"></a> -->
		<a class="online-3" href="javascript:oopen('<?php echo U(6,['callback'=>'toform']) ?>')" target="_blank"></a>
		<a class="online-4" href="javascript:oopen('<?php echo $system_link2 ?>')" target="_blank"></a>
		<a class="online-6" id="backtop" href="javascript:goTop();"></a>
	</div>
	<!-- 固定部分结束  -->
	<script src="/style/js/jquery-2.2.4.min.js"></script>
	<script src="/style/js/jquery.lazyload.min.js"></script>
	<script src="/style/js/jquery.carousel.min.js"></script>
	<script src="/style/js/jquery.fancybox.min.js"></script>
	<!-- 数字滚动 -->
	<script src="/style/js/countup.min.js"></script>
	<script src="/style/js/main.js"></script>
	<script src="/style/js/liuyan.js"></script>

	<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
	<div id="SkypeButton_Call_hury88_1" style="display:none">
	 <script type="text/javascript">
	 Skype.ui({
	 "name": "chat",
	 "element": "SkypeButton_Call_hury88_1",
	 "participants": ["<?php echo $system_link1 ?>"]
	 });
	 </script>
	</div>
</body>

</html>
	<script>
		function oopen(u) {return window.open(u,'','left=150,top=150,width=550,height=300');}
	</script>

