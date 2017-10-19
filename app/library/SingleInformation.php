<?php
// 单条信息列表
class SingleInformation
{
	public function __construct($pid,$ty)
	{
		list($this->display, $this->pagestr) = self::_list($pid,$ty);
	}

	public static function _list($pid,$ty,$ti=0)
	{
		$list = '';
		$lists = [];
		$where = m_gWhere($pid,-1);

    	$pageConfig = [
	        'table' => 'news_cats',//条件
	        'where' => $where,//条件
	        'field' => 'id,contentTemplate,catname,img1,img2,img3',//表
	        'order' => 'disorder desc, id asc',//表
	        'psize' => '4',//条数
	        'style' => 'data-href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
	    foreach ($data as $value) {
	    	extract($value);
	    	$catImg2 = src( $value['img2'] );
	    	$catImg3 = src( $value['img3'] );
    		$u = U($pid.'/detail', ['pid'=>$pid,'ty'=>$ty]);
    		$li = <<<T
<li><a href="$u">
	<div style="padding-top: 45px;" class="chanpingliall">
		<img style="position:absolute;left:39%;top:-12.5%" data-img="$catImg3" data-img2="$catImg2" src="$catImg2" alt="">
		<p>$catname</p>
		<p style="padding:10px;">$contentTemplate</p>
	</div></a>
</li>
T;
    		$list .= $li;
    		array_push($lists, $li);
		}

		$list or $list = config('other.nocontent');
		return [$list, $pagestr, $lists];
	}

	// 数据层
	public static function data($config = [])
	{
		return pagenation($config, 'show_front_lazy');

	}

}
