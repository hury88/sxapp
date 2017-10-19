<?php
// 图文列表
class TextList
{
	public function __construct($pid,$ty)
	{
		list($this->display, $this->pagestr) = self::_list($pid,$ty);

		$this->display = <<<EOF
<div class="fourAll">
		$this->display
</div>
EOF;
	}

	public static function _list($pid,$ty)
	{
		$list = '';
		$where = m_gWhere($pid,$ty);

    	$pageConfig = [
	        'where' => $where,//条件
	        'field' => 'id,title,content,sendtime,name,img1',//表
	        'psize' => '3',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
			$class1 = 'style="float:left"';
			$class2 = 'style="float:right"';
			if ($key%2==1) {
				$class1 = 'style="float:right"';
				$class2 = 'style="float:left"';
			}

    		extract($value);
    		$img1 = src($img1);
    		$content = htmlspecialchars_decode($content);
    		// $time = date('Y-m-d',$sendtime);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<EOF
<div class="inter1">
	<div class="inter1_left" $class1>
		<img title="$title" src="$img1"/>
	</div>
	<div class="inter1_right" $class2>
		<a href="$U"><h2>$title</h2></a>
		$content
		<a href="$U"><p><img src="/style/images/more.png"/></p></a>
	</div>
	<div class="clear"></div>
</div>
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
