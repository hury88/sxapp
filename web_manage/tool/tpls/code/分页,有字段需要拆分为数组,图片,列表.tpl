	public static function _list()
	{
		$list = $imgList = $titleList = '';
	    list($data) = self::data();
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$content_array = explode("\r\n", $content);
    		$content = '';
    		foreach ($content_array as $content_value) {
    			$content .= '<li>● '.$content_value.'</li>';
    		}
    		// $url = U('_PID_/detail', ['id'=>$id]);
    		$list .= <<<T
<div class="show_time">
	<h2>$ftitle</h2>
	<p><span>案例</span>$title</p>
	<ul>
		$content
	</ul>
</div>
T;
	}
		$list or $list = config('other.nocontent');
		return <<<T
<div class="show_f">
	$list
</div>
T;
	}

	// 数据层
	public static function data($config = [])
	{
    	$pageConfig = [
	        'where' => m_gWhere(_PID_,_TY_),//条件
	        'field' => 'id,title,ftitle,img1,content',//表
	        'psize' => '11',//条数
	        'style' => 'data-href',
	    ];
	    $pageConfig = array_merge($pageConfig, $config);
		return pagenation($pageConfig, 'show_front_lazy');

	}
