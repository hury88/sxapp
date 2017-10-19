<?php
class _CLASS_
{
	public static function index()
	{
		$bread = config('pcBread');
    	list($list, $pagestr) = self::_list();

		return <<<HTML
<!--内容部分-->

<div id="custom">
	<div class="dump">
	    $bread
	</div>
</div>
<div id="search" class="clearfix">
	<div class="sea_left fl">
		$list
		<div class="page">
			<ul>
				$pagestr
			</ul>
		</div>
	</div>
</div>
HTML;
	}

	public static function _list()
	{
		$list = '';
		$where = m_gWhere(_PID_,_TY_);

    	$pageConfig = [
	        'where' => $where,//条件
	        'field' => 'id,title,introduce,img1',//表
	        'psize' => '9',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$url = U('news/detail', ['id'=>$id]);
    		$list .= <<<T
<div class="s_l_box clearfix">
	<a title="$title" href="$url">
		<img src="$img1" alt="$title" class="fl" />
		<div class="right fr">
			<p><em>新闻动态</em>$title</p>
			<div>
				$introduce
			</div>
			<span>查看详情>></span>
		</div>
	</a>
</div>
T;
		}
		$list or $list = config('other.nocontent');
		return [$list, $pagestr];
	}

	// 数据层
	public static function data($config = [])
	{
    	$pageConfig = [
	        'where' => m_gWhere(_PID_,_TY_),//条件
	        'field' => 'id,title,ftitle,img1,img2',//表
	        'psize' => '10',//条数
	        'style' => 'data-href',
	    ];
	    $pageConfig = array_merge($pageConfig, $config);
		return pagenation($pageConfig, 'show_front_mvc_pc');

	}

}
