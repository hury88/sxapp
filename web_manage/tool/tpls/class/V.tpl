<?php
class V
{
	public $display = '';
	public $pagestr = '';

	public static $TEMPLATE_MAP = [
		'__URL__' => '\'.$URL.\'',
		'__DATE__' => '%date(\'Y-m-d\',%$sendtime%)%',
		'__IMG1__' => '%src(%$img1%)%',
		'__IMG2__' => '%src(%$img2%)%',
		'__TITLE__' => '%$title%',
		'__INTRODUCE__' => '%htmlspecialchars_decode(%$introduce%)%',
	];
	public function __construct($pid,$ty,$tpl='')
	{
		// $bread = config('pcBread');

    	list($this->display, $this->pagestr) = self::_list($pid,$ty,$tpl);
	}

	public static function _list($pid,$ty,$tpl)
	{
		$tyFind = M('news_cats')->field('tpl,pagesize')->where(['id'=>$ty])->find();
		$pagesize = $tyFind['pagesize'];
		if (! $tpl) {
			$tpl = $tyFind['tpl'] ? $tyFind['tpl'] : M('news_cats')->where(['id'=>$pid])->getField('tpl');
		}

		$tpl = htmlspecialchars_decode($tpl);

		$tpl = str_replace(array_keys(self::$TEMPLATE_MAP), array_values(self::$TEMPLATE_MAP), $tpl);


		#解析模板开始
		preg_match_all('/%\$(.*?)%/',$tpl,$match);
		// 先找函数
		$tpl = preg_replace('/%(.*?)[(]["]?[%](.*?)[%][)]%/','\'.$1($2).\'',$tpl);
		// 解析变量
		$tpl = preg_replace('/%(.*?)%/','\'.$1.\'',$tpl);

		array_push($match[1],'pid','id');

		$field = implode(',',str_replace('$','',array_unique($match[1])));
		#解析模板结束

		$list = '';
		$where = m_gWhere($pid,$ty);

    	$pageConfig = [
	        'where' => $where,//条件
	        'field' => $field,//表
	        'psize' => $pagesize,//条数
	        'style' => 'href',
	    ];
	    list($data, $pagestr, $totalRows) = self::data($pageConfig);
		// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
		foreach ($data as $key => $value) {
    		extract($value);
    		$URL = U($pid.'/detail', ['id'=>$id]);
    		eval("\$list .= '$tpl';");
		}
		$list or $list = config('other.nocontent');
		return [$list, $pagestr];
	}

	// 数据层
	public static function data($config = [])
	{
    	$pageConfig = [
	        'where' => m_gWhere(3,10),//条件
	        'field' => 'id,title,introduce,sendtime,name,img1',//表
	        'psize' => '5',//条数
	        'style' => 'data-href',
	    ];
	    $pageConfig = array_merge($pageConfig, $config);
		return pagenation($pageConfig, 'show_front_mvc_pc');

	}

}
