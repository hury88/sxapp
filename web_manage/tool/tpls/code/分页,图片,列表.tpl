    function _list()
	{
		$list = '';
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$url = U('_PID_/detail', ['id'=>$id]);
    		$list .= <<<T
<div class="s_l_box clearfix">
	<a title="$title" href="$url">
		<img src="$img1" alt="$title" class="fl" />
		<div class="right fr">
			<p><em>行业新闻</em>$title</p>
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
	        'style' => 'href',
	    ];
	    $pageConfig = array_merge($pageConfig, $config);
		return pagenation($pageConfig, 'show_front_mvc_pc');

	}