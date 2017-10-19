<div id="expert" class="aa expert">
<div class="newlbTit"><span>With a series of products</span></div>
	<div class="bd">
		<ul>
			<?php echo bottom() ?>
		</ul>
	</div>
	<div class="hd">
		<ul></ul>
	</div>
	<script type="text/javascript">TouchSlide({slideCell:"#expert",titCell:".hd ul",mainCell:".bd ul",effect:"leftLoop",autoPlay:true,autoPage:true,delayTime:1000,interTime:6000,});</script>
</div>
<!--pc结束-->
<?php
	// right([$pid,$ty],[$controlle,$title]);
function bottom($pid=2,$ty=-1){
	$ul = '';
    $data = M('news')->field('id,pid,introduce,title,img1')->where(m_gWhere($pid, $ty))->order(config('other.order'))->limit(30)->select();
    // dump($data);
    $chunk = array_chunk($data, 4, true);
    // dump($chunk);

	foreach ($chunk as $chunk_data) {
	$li = '';
	foreach ($chunk_data as $key => $value) {
		extract($value);
		$U = U($pid .'/detail', ['id'=> $id]);
		$introduce = cutstr( strip_tags($introduce), 63 );
		$img1 = src( $img1 );
		$style = $key == 0 ? 'style="margin-right:15px;"' : 'style="margin-right:15px;"';
		$li .= <<<T
<a href="$U"><div class="expert1" $style>
	<div class="newlbTop">
		<img src="$img1"/>
	</div>
	<div class="newlbBom">
		<h3>$title</h3>
		<p>$introduce</p>
	</div>
</div></a>
T;
	}
	$ul .= <<<T
<li class="expert_scr">
	$li
</li>
T;

	}
	unset($list,$chunk,$data,$pid,$ty,$key,$value,$title,$U,$li);
	return $ul;
}
?>
