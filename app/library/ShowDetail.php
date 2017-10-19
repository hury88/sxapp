<?php
// 备用列表
class ShowDetail
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
		$id = I('get.id', 0, 'intval');
		$list = '';
    	$pageConfig = [
	    	'table' => 'pic',
	        'where' => "ti=$id",//条件
	        'field' => 'content,img1',//表
	        'psize' => '3',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$content = htmlspecialchars_decode($content);
    		$list .= <<<EOF
<div class="inter1">
	<div class="inter1_left">
		<img src="$img1"/>
	</div>
	<div class="inter1_right">
		$content
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
