<?php
class Lister{

	/**
	 * @var object 对象实例
	 */
	protected static $instance;

	/**
	 * 初始化
	 * @access public
	 * @param array $options 参数
	 * @return \think\Request
	 */
	public static function instance($options = [])
	{
	    if (is_null(self::$instance)) {
	        self::$instance = new static($options);
	    }
	    return self::$instance;
	}

    public function __construct($q,$pid,$ty,$tty){
    	$map = array('pid'=>$pid,'ty'=>$ty);
    	if ($q) {$map['title'] = array('like','%'.$q.'%');/*搜索*/ }
    	if ($tty) {$map['tty'] = $tty;}
    	$this->map = $map;
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
	        'style' => 'href',
	    );
		list($data,$pagestr,$totalRows) = Page::paging($pageConfig,'show_front');
    	//if( empty($data) ){exit('<p style="text-align:center;width:100%;padding-top:20px;">内容更新中</p>'); }
    	$tpl = self::$$m;
    	$this->paging = $pagestr;
    	$this->totalRows = $totalRows;
    	return array($data,$tpl);
    }

    public function display()
    {
    	return
	    	'<ul>' . $this->display . '</ul>' .
	    	'<div class="inside-pager">' . $this->paging . '</div>';
    }


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
	private $order = 'isgood desc,disorder desc,sendtime desc';
	private $psize = 12;
	private $table = 'news';
	private $field = '*';
	private $map   = array();
	public  $data  = '';//数据
	public  $paging= '';//模板
	public  $display= '';//html

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
	public function s1($psize=6){//新闻列表
		list($data , $tpl) = $this->j(__FUNCTION__,$psize);
		if(empty($data)){$this->display = Config::get('other.nocontent');return;}
		$need = array('%URL%','%TITLE%','%CUTTITLE%','%TIME%','%IMG%','%INTRODUCE%','%HITS%');
		$temp = '';
		foreach ($data as $key => $row) {
			$url   = getUrl($row['id'],'view');
			$title = $row['title'];
			$cutTitle = cutstr($title,20);
			$introduce = cutstr($row['introduce'],28);
			$hits = $row['hits'];
			$time = date('Y-m-d',$row['sendtime']);
			$img   = src($row['img1']);
			$temp .= str_replace($need,array($url,$title,$cutTitle,$time,$img,$introduce,$hits),$tpl);
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


	// private static $s5 =' <li> <a title="%TITLE%" href="%URL%"> %CUTTITLE%<span>%TIME%</span></a> </li>';
	private static $s5 =' <li>
	                        <a title="%TITLE%" href="%URL%">
	                            <p class="area-intro flo_left">%CUTTITLE%</p>
	                            <span class="area-time flo_right">%TIME%</span>
	                            <div class="clearfix"></div>
	                        </a>
	                    </li>';
	public function s5($psize=12){//单条信息
		list($data , $tpl) = $this->j('s5',$psize);
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
    private static $s9= '<div class="roomlist_spance page_wrap"></div>
						<div class="cp_ind1 clr">
						    <ul class="cplist_box">
						        <li>
						                <div class="tupian clr">
						                    <i><a href="%URL%"><img src="%IMG%"/></a></i>
						                </div>
						                <div class="jieshuo clr">
						                    <h5><a href="%URL%">%CUTTITLE%</a><i class="pr">%PRICE%</i></h5>
						                    <div class="clr"></div>
						                    <ul>
						                       %SOURCE%
						                    </ul>
						                    <div class="dizhi clr"><i><img src="images/local_ico1.png"/> </i>%LINKURL%</div>
						                </div>
						        </li>
						       </ul>
						</div>';
	public function s9($psize=6){//新闻2
		$istop =    I('get.cid',0,'intval');if(!empty($istop))$this->map['istop'] = $istop;
		$istop2 =   I('get.tid',0,'intval');if(!empty($istop2))$this->map['istop2'] = $istop2;
		list($data , $tpl) = $this->j(__FUNCTION__,$psize);
		if(empty($data)){$this->display =  C('NO_RESULT');return;}
		$need = array('%URL%','%TITLE%','%CUTTITLE%','%IMG%','%LINKURL%','%PRICE%','%SOURCE%');
		$temp = '';
		foreach ($data as $key => $row) {
			extract($row);
			$url   	  = 	getUrl($id,'show');
			$cutTitle = 	cutstr($title,18);
			$img 	  = 	src($img1);
			$source    = explode('|',$relative);
			$source = M('news')->where(array('pid'=>14,'ty'=>19,'isstate'=>1,'relative'=>array('in',$relative)))->getField('title',true);
			$sourceList='';
			foreach ($source as $value) {
				$sourceList.="<li>$value</li>";
			}
			$temp    .= 	str_replace($need,array($url,$title,$cutTitle,$img,$linkurl,$price,$sourceList),$tpl);
		}
		$this->display = $temp;
		UNSET($data,$need,$tpl,$key,$row,$img,$url,$title,$temp);
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
