/* 
设计稿1242px 150px 为1rem
->1242/150=8.28
->屏幕宽度/8.28=实际1rem的像素值
适配最小宽度320 最大宽度414
ps：必须放在head上保证最先加载

1080/10.8
*/
+ function() {
	// var tid=null;
	remLayout();

	function remLayout() {
		var w = document.documentElement.clientWidth;
		w = w > 750 ? 750 : w;
		w = w <= 320 ? 320 : w;
		document.documentElement.style.fontSize = w / 7.5 + 'px';
	}
	window.addEventListener('resize', function() {
		// clearTimeout(tid);
		// tid = setTimeout(remLayout, 100);
		remLayout();
	}, false);

}();