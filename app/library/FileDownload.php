<?php
// 文件下载
class FileDownload
{
	public function __construct($pid,$ty)
	{
		$this->display = [];
		list($this->display['pc'], $this->display['wap'], $this->pagestr) = self::_list($pid,$ty);
	}

	public static function _list($pid,$ty,$ti=0)
	{
		$list = $list2 = '';
		$where = m_gWhere($pid,$ty);

    	$pageConfig = [
	        'where' => $where,//条件
	        'field' => 'id,title,content,sendtime,name,img1',//表
	        'psize' => '4',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$introduce = htmlspecialchars_decode($content);
    		// $time = date('Y-m-d',$sendtime);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<EOF
<div class="all1" style="margin-right:2%;width:45%;margin-bottom:1%">
	<div class="allleft" style="position:relative;">
		<img src="$img1" style="width: 100%;" xq_big="true" setting='{"pwidth":270,"pheight":260,"margin_top":0,"margin_left":0}' />
		<a href="$U"><img style="position:absolute;bottom:37px;right:0" src="/style/images/fdj.jpg" alt="icon fdj"></a>
	</div>
	<div class="allright">
		<a href="$U"><p>$title</p></a>
		<p>$introduce</p>
		<p class="add" data-id="$id" style="color: #f00;"><img src="/style/images/download.png" />DOWNLOAD</p>
	</div>
</div>
EOF;
    		$list2 .= <<<EOF
<div class="all1">
	<a href="$U"><h4>$title</h4></a>
	<div class="allleft" style="position:relative;">
		<img src="$img1">
		<a href="$U"><img style="width:6%;height:10%;position:absolute;bottom:0;right:5%" src="/style/images/fdj.jpg" alt="icon fdj"></a>
	</div>
	<div class="allright">
		<p>$title</p>
		<p>$introduce</p>
		<p class="madd add3sj" data-id="$id" style="color: #f00;"><img src="/style/images/download.png" />DOWNLOAD</p>
	</div>
</div>
EOF;
		}
		$list or $list = config('other.nocontent');
		$list2 or $list2 = config('other.nocontent');
		return [$list,$list2, $pagestr];
	}

	// 数据层
	public static function data($config = [])
	{
		return pagenation($config, 'show_front_mvc_pc');

	}

}
