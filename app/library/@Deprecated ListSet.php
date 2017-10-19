<?php
class ListSet{

	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	private static $s4 ='';
	private static $s2 ='';
	private static $s6 ='';
	private static $s7 ='';
	private static $row  = '';//当前行的数据
	/*
		$showtype==1): showtype1($q,$ty) //新闻?>
		$showtype==2): showtype2($id)//单页?>
		$showtype==3): showtype3($ty) //图片列表?>
		$showtype==5): showtype5($ty) //单条?>
		$showtype==9): showtype9($q,$ty) //新闻2
		$showtype==8): showtype8($q,$ty) //文件下载
	*/
	private static $options = [
		'pid' => 0,
		'ty'  => 0,
		'tty' => 0,
	];
	private $order = 'isgood desc,disorder desc,sendtime desc';
	private $psize = 12;
	private $table = 'news';
	private $field = '*';
	private $map   = array();
	public  $data  = '';//数据
	public  $paging= '';//模板
	public  $display= '';//html


	public function __construct($options){

		self::$options = array_merge(self::$options, $options);

		extract($options);

		self::$options['pid'] or self::$options['pid'] = I('get.pid', 0, 'intval');
		self::$options['ty']  or self::$options['ty']  = I('get.ty' , 0, 'intval');
		self::$options['tty'] or self::$options['tty'] = I('get.tty', 0, 'intval');

		extract(self::$options);

		$map = array('pid'=>$pid);
		// if ($q) {$map['title'] = array('like','%'.$q.'%');/*搜索*/ }
		if ($ty) {$map['ty'] = $ty;}
		if ($tty) {$map['tty'] = $tty;}
		$this->map = $map;
	}

	/**
	 * 初始化
	 * @access public
	 * @param array $options 参数
	 */
	public static function instance($options = [])
	{
	    if (is_null(self::$instance)) {
	        self::$instance = new static($options);
	    }
	    return self::$instance;
	}


    private static $s1='<li>
			            <div class="tu_le fl clr">
			                <a title="%TITLE%" href="%URL%"><img src="%IMG%"/> </a>
			            </div>

			            <div class="weniz fr clr">
			                <h3>%CUTTITLE%</h3>
			                <p>%INTRODUCE%</p>
			                <div class="scka clr">
			                    <span class="fl">%TIME%</span>
			                    <span class="fr"><i><img src="images/eyes.png"/> </i>%HITS%</span>
			                </div>
			            </div>
		        	</li>';
	public function s1($psize=6, $tplArg=''){//新闻列表
		$order = I('order', '', 'trim');if($order)$this->order = $order . ' desc';
		if ($order == 'isgood') {
			$this->order = 'isgood desc,dotlike desc,share desc,sendtime desc';
		}
		$this->map['istop'] = 0;
		list($data , $tpl) = $this->j(__FUNCTION__,$psize);

		$tplArg && $tpl = $tplArg;

		if(empty($data)){$this->display = Config::get('other.nocontent');return;}
		$need = array('%URL%','%ID%','%TITLE%','%TIME%','%IMG%','%INTRODUCE%','%HITS%','%DOTLIKE%','%SHARE%');
		$temp = '';
		foreach ($data as $key => $row) {
			extract($row);
			$url   = U('news/view', ['id' => $id]);
			$dotlike = M('dotlike')->where("news_id=$id and type=1")->count();
			$share = M('dotlike')->where("news_id=$id and type=2")->count();
			M('news')->where("id=$id")->update(['dotlike'=>$dotlike,'share'=>$share]);
			$time = date('Y-m-d', $sendtime);
			$img   = src($img1);
			$temp .= str_replace($need,array($url,$id,$title,$time,$img,$introduce,$hits,$dotlike,$share),$tpl);
		}
		$this->display = $temp;
		UNSET($data,$need,$tpl,$key,$row,$img,$url,$title,$temp);
	}
	public function s2(){}

    private static $s3='';
	public function s3($psize=4){//图片,图文
	}

	public function s4($psize=4){//友情链接
	}


	private static $s5 =' <li> <a title="%TITLE%" href="%URL%"> %CUTTITLE%<span>%TIME%</span></a> </li>';
	public function s5($psize=12){//单条信息
		list($data , $tpl) = $this->j(__FUNCTION__,$psize);
		if(empty($data)){$this->display =  Config::get('other.nocontent');return;}
		$need = array('%URL%','%TITLE%','%CUTTITLE%','%TIME%');
		$temp = '';
		foreach ($data as $key => $row) {
			$url   = getUrl($row['id'],'view');
			$title = $row['title'];
			$time  = $row['sendtime'] ? date('Y-m-d',$row['sendtime']) : date('Y-m-d',time());
			$cutTitle = cutstr($title,42);
			$temp .= str_replace($need,array($url,$title,$cutTitle,$time),$tpl);
		}
		$this->display = $temp;
		UNSET($data,$need,$tpl,$key,$row,$img,$url,$title,$temp);
	}



    private static $s8= '<li>
							<span class="jieshao">%CUTTITLE%</span>
							<span class="shijian">%TIME%</span>
							<a title="%TITLE%" download href="%LINK%" class="xiazai"></a>
						</li>';
	public function s8($psize=10){//下载中心

		list($data , $tpl) = $this->noPaging(__FUNCTION__);
		if(empty($data)){$this->display =  Config::get('other.nocontent');return;}
		$need = array('%LINK%','%TITLE%','%CUTTITLE%','%TIME%');
		$temp = '';
		foreach ($data as $key => $row) {
			if($row['istop']){
				$htppPattern = '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/';
				if(preg_match($htppPattern,$row['linkurl']))
					$link=$row['linkurl'];
				else continue;
			}else{
				$link = src($row['file']);
			}
			$title = $row['title'];
			$cutTitle = cutstr($title,42);
			$time  = $row['sendtime'] ? date('Y-m-d',$row['sendtime']) : date('Y-m-d',time());
			$temp .= str_replace($need,array($link,$title,$cutTitle,$time),$tpl);
		}
		$this->display = $temp;
		UNSET($data,$need,$tpl,$key,$row,$img,$url,$title,$temp);
	}
    public static $s9= <<<S9
    	<li class="project-item case-li">
    	    <a title="%TITLE%" class="db" href="%URL%">
    	        <div class="ov itemimg-box">
    	            <img src="%IMG%" alt="%TITLE%">
    	            <div class="itemli-cover"></div>
    	        </div>
    	        <div class="txt">
    	            <p>%TITLE%</p>
    	            <span>%FTITLE%</span>
    	        </div>
    	    </a>
    	</li>
S9;

	public function s9($psize=16, $controller){//新闻2
		// $istop =    I('get.category',0,'intval');if(!empty($istop))$this->map['istop'] = $istop;
		// $istop2 =   I('get.tid',0,'intval');if(!empty($istop2))$this->map['istop2'] = $istop2;
		list($data , $tpl) = $this->j(__FUNCTION__,$psize);
		if(empty($data)){$this->display = config('other.nocontent');return;}
		$need = array('%URL%','%TITLE%','%FTITLE%','%IMG1%','%IMG2%');
		$temp = '';
		foreach ($data as $key => $row) {
			extract($row);
			$url   	  = 	U($controller.'/detail', ['id' => $id]);
			$cutTitle = 	cutstr($title,18);
			$img1 	  = 	src($img1);
			$img2 	  = 	src($img2);
			// $source    = explode('|',$relative);
			// $source = M('news')->where(array('pid'=>14,'ty'=>19,'isstate'=>1,'relative'=>array('in',$relative)))->getField('title',true);
			$temp .= str_replace($need,array($url,$title,$ftitle,$img1,$img2),$tpl);
		}
		$this->display = $temp;
		UNSET($data,$need,$tpl,$key,$row,$img1,$img2,$url,$title,$temp);
		return [$this->display];
	}
    private static $s11='<li>
							<div class="pic"><a href="%URL%"><img src="%IMG%"></a></div>
							<div class="tl">
								<h1><a href="%URL%">%CUTTITLE%</a></h1>
								<p><a  href="%URL%"><img src="images/hdjz_icon.png"></a><a href="%URL%">%LINKURL%</a></p>
							</div>
							<div class="rq">%TIME%</div>
						</li>';
	public function s11($psize=6){//新闻列表
		$istop = I('get.n',0,'intval');
		$this->map['_string']="jztime>".time();
		list($data , $tpl) = $this->j(__FUNCTION__,$psize);
		if(empty($data)){$this->display = Config::get('other.nocontent');return;}
		$need = array('%URL%','%TITLE%','%CUTTITLE%','%TIME%','%IMG%','%INTRODUCE%','%LINKURL%');
		$temp = '';
		foreach ($data as $key => $row) {
			$url   = getUrl($row['id'],'activities');
			$title = $row['title'];
			$cutTitle = cutstr($title,20);
			$introduce = cutstr($row['introduce'],28);
			$linkurl = $row['linkurl'];
			$time = date('m-d',$row['jztime']);
			$img   = src($row['img1']);
			$temp .= str_replace($need,array($url,$title,$cutTitle,$time,$img,$introduce,$linkurl),$tpl);
		}
		$this->display = $temp;

		UNSET($data,$need,$tpl,$key,$row,$img,$url,$title,$temp);
	}


    public function j($m,$psize=0,$table=''){
    	if (!empty($psize)) {$this->psize=$psize;}
    	if (!empty($table)) {$this->table=$table;}
    	$pageConfig = array(
	        'where' => $this->map,//条件
	        'order' => $this->order,//排序
	        'psize' => $this->psize,//条数
	        'table' => $this->table,//表
	        'field' => $this->field,//表
	        'style' => 'data-href',
	    );
		list($data,$pagestr,$totalRows) = Page::paging($pageConfig,'show_front_mvc_pc');
    	//if( empty($data) ){exit('<p style="text-align:center;width:100%;padding-top:20px;">内容更新中</p>'); }
    	$tpl = self::$$m;
    	$this->paging = $pagestr;
    	$this->totalRows = $totalRows;
    	return array($data,$tpl);
    }
    public function noPaging($m){
    	$table = $this->table;
    	$field = $this->field;
    	$where = $this->map;
    	$order = $this->order;
    	if (!empty($table)) {$this->table=$table;}
        $data  = M($table)->field($field)->where($where)->order($order)->select();
    	$pageConfig = array(
	        'where' => $this->map,//条件
	        'order' => $this->order,//排序
	        'psize' => $this->psize,//条数
	        'table' => $this->table,//表
	        'style' => 'data-url',
	    );
    	$tpl = self::$$m;
    	$this->data   = $data;
    	return array($data,$tpl);
    }

    public function q($q,$pid,$ty,$tty){
    	$map = array();
    	if ($pid) $map['pid']=$pid;
    	if ($ty)  $map['ty']=$ty;
    	$map['_string'] = ' (sku like "%'.$q.'%")  OR ( title like "%'.$q.'") OR ( cas like "%'.$q.'") ';
    	$this->map = $map;
    	list($data , $tpl) = $this->j('s1',27,'products');
    	if(empty($data)){$this->display = Config::get('other.nocontent');return;}
    	$temp = '';
    	foreach ($data as $key => $row) {
    		$bg = $key%2==0 ? ' bgcolor="#eef3f7"' : '';
    		$id    = $row['id'];
    		$idh   = $row['id']+10000;
    		$sku   = $row['sku'];
    		$cas   = $row['cas'];
    		$unit  = $row['unit'];
    		$title = $row['title'];
    		$temp .= sprintf($tpl,$bg,$idh,$sku,$title,$cas,$unit,$id);
    	}
    	$this->display = $temp;
    	UNSET($data,$need,$tpl,$key,$row,$img,$url,$title,$temp);
    }
}
