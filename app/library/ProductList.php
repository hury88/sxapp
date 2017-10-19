<?php
// 产品列表
class ProductList
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
	        'field' => 'id,catname,img1,img2,img3',//表
	        'order' => 'disorder desc, id asc',//表
	        'psize' => '4',//条数
	        'style' => 'data-href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
	    foreach ($data as $value) {
	    	$ty = $value['id'];
	    	$tyName = $value['catname'];
	    	$catImg2 = src( $value['img2'] );
	    	$catImg3 = src( $value['img3'] );
	    	#获取 二级下的列表数据
	    	$dataCategory = M('news')->where( m_gWhere($pid,$ty) )->order(config('other.order'))->getField('id,title');
	    	$dataCategory or $dataCategory=[];
	    	$samllLi = '';
	    	// dump($dataCategory);
		foreach ($dataCategory as $id => $title) {
    		$u = U($pid.'/detail', ['id'=>$id]);
    		$samllLi .= '<p><a href="'.$u.'">'.$title.'</a></p>';
	    }
    		$li = <<<T
<li>
	<div class="chanpingliall" style="padding-top: 45px;min-height:260px;">
		<img style="position:absolute;left:38%;top:-14%" data-img="$catImg3" data-img2="$catImg2" src="$catImg2" alt="">
		<p>$tyName</p>
		$samllLi
	</div>
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
