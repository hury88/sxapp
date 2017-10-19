<?php
// 图片列表
class PictureList
{
	public function __construct($pid,$ty)
	{
		list($this->display, $this->pagestr) = self::_list($pid,$ty);

		$this->display = <<<EOF
<div class="jq22-container" style="overflow: hidden;">
	<div class="full-length">
		<div class="container">
			<!-- Effect-1 -->
			<ul>
				$this->display
				<div style="clear: both;"></div>
			</ul>
			<!-- Effect-1 End -->
		</div>
	</div>
</div>
EOF;
	}

	public static function _list($pid,$ty,$ti=0)
	{
		$list = '';
		$where = m_gWhere($pid,$ty);

    	$pageConfig = [
	        'where' => $where,//条件
	        'field' => 'id,title,introduce,sendtime,name,img1',//表
	        'psize' => '9',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		// $introduce = htmlspecialchars_decode($introduce);
    		// $time = date('Y-m-d',$sendtime);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<EOF
<a href="$U"><li>
	<div class="port-1 effect-1">
		<div class="image-box">
			<img src="$img1" alt="$title">
		</div>
		<div class="text-desc">
			<h3>$title</h3>
			<a href="$U" title="$title" class="btn">Read More</a>
		</div>
	</div>
</li></a>
EOF;
		}
		$list or $list = config('other.nocontent');
		return [$list, $pagestr];
	}

	// 数据层
	public static function data($config = [])
	{
		return pagenation($config, 'show_front_mvc_pc');

	}

}
