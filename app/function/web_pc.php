<?php

function returnJson($status,$msg,$dom=false){
    $arr = [
    	'status' => $status,
    	'msg'    => $msg,
    ];
    $dom && $arr['dom'] = $dom;
    unset($status,$msg,$dom);
    die( json_encode($arr) );
}

function dieJson($error,$message,$redirect=false){
    $arr = [
    	'error' => $error,
    	'message'    => $message,
    ];
    $redirect && $arr['redirect'] = $redirect;
    unset($error,$message,$redirect);
    die( json_encode($arr) );
}

function innerBanner($tpl = '<div class="bg_t"> <div> <h2>%s</h2> <p>%s</p> </div> </div>')
{
	global $pid_img1,$pid_catname,$pid_catname2,$pid,$ty;
	/*$pid_catname && */$pid_catname3 = ucfirst($pid_catname2);
	// $tpl = sprintf($tpl, $pid_catname, $pid_catname3);
	$data = M('news_cats')->field('id,catname')->where(['pid'=>$pid])->order('disorder desc,id asc')->select();
	$li = '';
	foreach ($data as $value) {
		extract($value);
		$class = $id == $ty ? ' class="select"' : '';
		$link = U($pid, ['ty' => $id]);
		$li .= '<li'.$class.'><a href="'.$link.'">'.ucfirst($catname).'</a></li>';
	}
	echo <<<B
	<div id="notice-tit" class="notice-tit">
		<ul>
			$li
		</ul>
	</div>
B;
}

function relative($where){//BANNER 专用
	$list='';
    $data = M('news')->field('id,title,img1,ftitle,introduce')->where($where)->order(Config::get('other.order'))->select();

	foreach ($data as $id => $row) {//获取轮播图 轮播pid
		extract($row);
		$url = U('case/detail', ['id'=> $id]);
		$img = src($img1);
		$list .= <<<T
		<li>
		    <a href="$url" title="$introduce">
		        <div class="caseimg-box">
		            <img alt="$introduce" src="$img"/>
		        </div>
		        <p class="case-name">$title</p>
		        <span>$ftitle</span>
		    </a>
		</li>
T;
		// $img = src($img1);
		// $content = htmlspecialchars_decode($content);
	}
	echo $list;
	unset($list,$pid,$ty,$row,$title,$img1,$ftitle,$tpl,$data);
}
// right([$pid,$ty],[$controlle,$title]);
function right($pt, $ct, $order=''){
	$ul = '';
	$order or $order = config('other.order');
	list($controller, $T) = $ct;
    $data = M('news')->field('id,title,hits')->where(m_gWhere($pt[0], $pt[1]))->order($order)->limit(30)->select();
    $chunk = array_chunk($data, 10, true);
	foreach ($chunk as $data) {//获取轮播图 轮播pid
	$li = '';
	foreach ($data as $i => $value) {//获取轮播图 轮播pid
		extract($value);
		$key = $i+1;
		$U = U($controller, ['id'=> $id]);
		if (1==$key) {
			$class = 'class="nmuone"';
		} elseif(2==$key) {
			$class = 'class="nmutwo"';
		} elseif(3==$key) {
			$class = 'class="nmuthree"';
		} else {
			$class = '';
		}
		$li .= <<<T
<dt $class><a href="$U"><i>$key</i>$title<span>$hits</span></a></dt>
T;
	}
	$ul .= <<<T
<li>
	<dl>
	$li
	</dl>
</li>
T;
	}
	unset($list,$chunk,$data,$pid,$ty,$key,$value,$title,$U,$li);
	return $ul;
}

// 用法 <li><a style="background-image: url(__IMG__);" href="{{$linkurl}}" target="_blank"></a></li>
function vv($pid,$ty,$tpl,$limit=0)
{
	list($field, $flag) = V::parse($tpl);
	$m = M('news')->field($field)->where(m_gWhere($pid,$ty))->order(config('other.order'));
	if ($limit) {
	    $m = $m->limit($limit);
	}
	$data = $m->select();

	$list = '';
	foreach ($data as $key => $value) {
		extract($value);
		if ($flag) {
			$URL = U($pid.'/detail', ['id'=>$id]);
		}
		eval(" \$list .= '$tpl';");
	}
	return $list;
}
function v($pid,$ty,$tpl,$limit=0)
{
	preg_match_all('/%\$(.*?)%/',$tpl,$match);
	#先找函数
	$tpl = preg_replace('/%(.*?)[(][%](.*?)[%][)]%/','\'.$1($2).\'',$tpl);
	#解析变量
	$tpl = preg_replace('/%(.*?)%/','\'.$1.\'',$tpl);
	// 是否要自动生成地址链接
	$flag = strpos($tpl, '__URL__');
	if ($flag) {
		$tpl = str_replace('__URL__','\'.$URL.\'',$tpl);
		array_push($match[1],'pid','id');
	}

	$field = implode(',',str_replace('$','',$match[1]));
	$m = M('news')->field($field)->where(m_gWhere($pid,$ty))->order(config('other.order'));
	if ($limit) {
	    $m = $m->limit($limit);
	}
	$data = $m->select();

	$list = '';
	foreach ($data as $key => $value) {
		extract($value);
		if ($flag) {
			$URL = U($pid.'/detail', ['id'=>$id]);
		}
		eval(" \$list .= '$tpl';");
	}
	return $list;
}

// 用法 <li><a style="background-image: url(%src(%$img1%)%);" href="%$linkurl%" target="_blank"></a></li>
function v_data($data,$tpl)
{
	preg_match_all('/%\$(.*?)%/',$tpl,$match);
	#先找函数
	$tpl = preg_replace('/%(.*?)[(][%](.*?)[%][)]%/','\'.$1($2).\'',$tpl);
	#解析变量
	$tpl = preg_replace('/%(.*?)%/','\'.$1.\'',$tpl);
	// 是否要自动生成地址链接
	$flag = strpos($tpl, '__URL__');
	if ($flag) {
		$tpl = str_replace('__URL__','\'.$URL.\'',$tpl);
		array_push($match[1],'pid','id');
	}

	$list = '';
	foreach ($data as $key => $value) {
		array_walk($value, 'array_walk_decode');
		extract($value);
		if ($flag) {
			$URL = U($pid.'/detail', ['id'=>$id]);
		}
		eval(" \$list .= '$tpl';");
	}
	return $list;
}

function pc_lefts($q,$pid,$ty)
{

	if ($q) {
		// echo '<li class="zong"><a href="javascript:;" style="background: url(img/6_03.png)no-repeat right center;line-height: 20px;padding-top: 5px;">搜索页面<br/>SEARCH</a></li><li class="on"><a style="background: url(img/6_03.png)no-repeat right center;">搜索结果</a></li>';
		// return ;
	}
	$tpl = '<li %s><a href="%s">%s</a></li>';
	$data = M('news_cats')->field('id,catname')->where(array('pid'=>$pid,'isstate'=>1))->order('disorder desc,id asc')->select();
	$pidURL = m_pidUrl($pid);
	$tmp='';
	foreach ($data as $key => $row) {
		$cur = $ty==$row['id'] ? 'class="news-navactive"' : '';
		$url = m_pidUrl($pid,$row['id']);
		// $tmp .= sprintf($tpl,$cur,$url,$row['catname']);
		$tmp .= sprintf($tpl,$cur,$url,$row['catname']);
	}
	echo $tmp;
	UNSET($tpl,$data,$key,$pidURL,$row,$url,$cur);
}


function erji_nav($pid)
{
	$navs = M('news_cats')->where('pid='.$pid.' and isstate=1')->order('disorder desc,id asc')->getField('id,catname');
	$li = '';
	foreach ($navs as $id=> $catname) {
		$u = U($pid,['ty'=>$id]);
		$li	.= '<p><a title="'.$catname.'" href="'.$u.'">'.$catname.'</a></p>';

	}
	unset($navs, $id, $catname);
	return $li;
}

function pc_nav()
{
	global $pid,$ty;
	$on = IS_INDEX ? ' style="color:#a0bf39"' : '';
	$pid = isset($pid) ? $pid : 0;
	$class=$temp='';//当前停留样式
	$tpl_ul = '<li class="item" %s>
					<a href="%s">%s</a>
					<div class="level-2">
						<ul>
							%s
						</ul>
						<div class="level-2pic">
							<img width="215" height="150" src="%s"/>
						</div>
					</div>
				</li>';
    $tpl_li = '<li> <a %s title="%s" href="%s">%s</a> </li>';

    $tmp1='';
	$navs = M('news_cats')->field('id,catname,img2')->where('pid=0 and id<=6 and isstate=1')->order('disorder desc,id asc')->select();
	foreach ($navs as $row) {
		$tmp2='';
		$thispid = $row['id'];
		$class = $thispid == $pid ? 'style="color:#a0bf39"' : '';
		$yiji_url = U($thispid);
		$yiji_catname = $row['catname'];
		$yiji_img = src($row['img2']);
		if (in_array($thispid, array(6))) {
			$tmp1 .= '<li class="item" '.$class.'><a href="'.$yiji_url.'">'.$yiji_catname.'</a></li>';
		} else {

			$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$thispid.' and isstate=1')->order('disorder desc,id asc')->select();
			foreach ($erji as $erjiRow) {
				$thisty = $erjiRow['id'];
				$class2 = $thisty == $ty ? 'style="color:#a0bf39"' : '';
				$erji_url = U($thispid, ['ty'=>$thisty]);
				$erji_catname = $erjiRow['catname'];
				$tmp2 .= sprintf($tpl_li,$class2,$erji_catname,$erji_url,$erji_catname);
			}
			$tmp1 .= sprintf($tpl_ul,$class,$yiji_url,$yiji_catname,$tmp2,$yiji_img);
		}
	}
	echo '<li class="item"' . $on . '"><a href="/">'.config('translator.home').'</a></li>' . $tmp1;
	unset($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
}

function wap_nav()
{
	global $pid,$ty;
	$on = IS_INDEX ? ' active' : '';
	$pid = isset($pid) ? $pid : 0;
	$class=$temp='';//当前停留样式
	$tpl_ul = '<li class="%s" >
					<a href="%s">%s</a>
					<ul class="level-3">
						%s
					</ul>
				</li>';
    $tpl_li = '<li> <a %s title="%s" href="%s">%s</a> </li>';

    $tmp1='';
	$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<=6 and isstate=1')->order('disorder desc,id asc')->select();
	foreach ($navs as $row) {
		$tmp2='';
		$thispid = $row['id'];
		$class = $thispid == $pid ? 'active' : '';
		// $yiji_url = U($thispid);
		$yiji_url = 'javascript:;';
		$yiji_catname = $row['catname'];
		if (in_array($thispid, array(6))) {
			$tmp1 .= '<li class="item '.$class.'"><a href="'.$yiji_url.'">'.$yiji_catname.'</a></li>';
		} else {

			$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$thispid.' and isstate=1')->order('disorder desc,id asc')->select();
			foreach ($erji as $erjiRow) {
				$thisty = $erjiRow['id'];
				$class2 = $thisty == $ty ? 'style="color:#a0bf39"' : '';
				$erji_url = U($thispid, ['ty'=>$thisty]);
				$erji_catname = $erjiRow['catname'];
				$tmp2 .= sprintf($tpl_li,$class2,$erji_catname,$erji_url,$erji_catname);
			}
			$tmp1 .= sprintf($tpl_ul,$class,$yiji_url,$yiji_catname,$tmp2);
		}
	}
	echo '<li class="'. $on . '"><a href="/">'.config('translator.home').'</a></li>' . $tmp1;
	unset($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
}

#常用小函数 统一前缀 m

	function m_pidUrl($pid,$ty=0)
	{
		$link = 'list.php?pid='.$pid;
		if (!empty($ty)) $link .= '&ty='.$ty;
		return $link;
	}//传入pid=>list.php?pid=n

	function pc_bread($q,$pid,$ty,$tty,$id)
	{//面包屑导航
		// global $tty,$ty,$pid,$id_title,$id;
		  //面包屑导航
		  //$bread = $tty ? : $ty ? : $pid ;
		if ($q) {
			// ECHO '搜索"'.$q.'"的结果';
			echo '搜索';
			return;
		}
		$array = [];
		$sp = ' > ';
		$breadTemp = '';


		$array[] = [config('translator.home'), '/'];
		// $breadTemp = '<a href="/" style="font-style:italic">'.config('translator.home').'</a>' .$sp;
		if($pid){
			// if (empty($ty)) {$separtor='';}
			$url = U(config('map_flip')[$pid]);
			$catname = v_news_cats($pid,'catname');
			$array[] = [$catname, $url];
			// $breadTemp .='<a href="'.$url.'" style="color: #4a81c1;">'.$catname.'</a>';
		}
		$ty_catname = v_news_cats($ty,'catname');
		if($ty && $catname != $ty_catname){
			if (empty($ty)) {$separtor='';}
			$url = U($pid,['ty'=>$ty]);
			$array[] = [ucfirst($ty_catname), $url];
		}

		if ($id){
			global $id_title;
			$array[] = [$id_title, 'javascript:;'];
			// $breadTempId='<a href="javascript:;" style="color: #4a81c1;">'.$id_title.'</a>';
		}
		$count = count($array)-1;
		foreach ($array as $key => $value) {
			if ($count==$key) {
				$breadTemp .= '<a href="javascript:;" style="color:#f00;">'.$value[0].'</a>';
			} else {
				$breadTemp .= '<a href="'.$value[1].'" style="font-style:italic">'.$value[0].'</a>'.$sp;
			}
		}
		global $news_cats_ty_catname;
		$news_cats_ty_catname = ucfirst($news_cats_ty_catname);
		return [
<<<T
<p style="padding-bottom: 30px;">
	<span style="color: #333;font-weight: bold;font-size: 26px;">$news_cats_ty_catname</span>
	<span style="float: right;cursor: pointer;font-size: 14px;">
		$breadTemp
	</span>
</p>
T
,
<<<T
<p style="padding-bottom: 30px;">
	<span style="color: #333;font-weight: bold;font-size: 26px;">$news_cats_ty_catname</span>

</p>
T
/**/
];
		UNSET($url,$catname,$breadTemp,$bread);
	}
