	function _list()
	{
	    $tmp = $list = '';
	    $data = v_list('news', 'id,title,img1,img2', m_gWhere(_PID_,_TY_));

		$data = array_chunk($data, 8);
		foreach ($data as $chunk) {
		$list = '';
			foreach ($chunk as $key => $value) {
	    		extract($value);
	    		$style = ($key) % 4 == 0 ? ' style="margin-left: 0px;"' : '';
	    		$img1 = src($img1);$img2 = src($img2);$url = MU('_PID_/detail', ['id'=>$id]);
	    		$list .= <<<T
<li$style>
	<img src="$img1" alt="$title" />
	<div class="bg">
		<a href="$url"><img src="$img2" /></a>
		<a href="$url">扫一扫，立即体验</a>
	</div>
</li>
T;
			}
		$tmp .= <<<T
<div class="swiper-slide">
	<ul class="clearfix">
		$list
	</ul>
</div>
T;
		}
		return <<<T
$tmp
T;
	}