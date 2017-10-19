<?php
// 单条信息
class NewsList
{
	public function __construct($pid,$ty)
	{
		list($this->display, $this->pagestr) = self::_list($pid,$ty);
	}

	public static function getFirstTi($pid,$ty)
	{
		return M('news')->where(m_gWhere($pid,$ty))->order(config('other.order'))->getField('id');
	}

	public static function _list($pid,$ty,$ti=0)
	{
		$list = '';
		$where = m_gWhere($pid,$ty);

    	$pageConfig = [
	        'where' => $where,//条件
	        'field' => 'id,title,introduce,sendtime,name,img1',//表
	        'psize' => '6',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$introduce = htmlspecialchars_decode($introduce);
    		$time = date('F d, Y',$sendtime);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<T
<div class="newsAll">
	<div class="newsLeft">
		<img src="$img1"/>
	</div>
	<div class="newsRight">
		<h3><a href="$U" title="$title">$title</a></h3>
		<p style="newsDate"><img src="/style/images/newsIcon.jpg"/><i>$time</i></p>
		<p>$introduce</p>

	</div>
	<div class="clear">

	</div>
</div>
T;
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
