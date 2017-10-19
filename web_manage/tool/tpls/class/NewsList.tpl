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
	        'psize' => '5',//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$introduce = htmlspecialchars_decode($introduce);
    		$time = date('Y-m-d',$sendtime);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<T
<li class="clr">
	<a class="photo" href="$U" title="$title"><img src="$img1" alt="" width="200" height="140"></a>
	<h3><a title="$title" href="$U">$title</a></h3>
	<p>$introduce</p>
	<div class="clear"></div>
	<table>
		<tr>
			<td>发布者：$name</td>
			<td>发布日期：$time</td>
			<td>点击量：<script type="text/javascript" src="/ModelCount/?id=$id"></script></td>
			<td><a href="$U">查看详情</a></td>
		</tr>
	</table>
</li>
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
