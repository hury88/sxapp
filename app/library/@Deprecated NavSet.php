<?php

class NavSet{

	//辅助栏目ID
	public $fuzhuId = 0;
	//当前地址
	public $selfUrl = '';
	public $yiji = array();//一级导航数组

	public $config = array(
		'map' 	=> array('pid'=>0,'id'=>0,'isstate'=>1),
		'order' => 'disorder desc,id asc',
	);


	public function __construct(){
		/*global $PHP_URL;
		$this->selfUrl = $PHP_URL;
		$fuzhuId = M('news_cats')->where('catname="辅助栏目"')->getField('id');
		$yiji = M('news_cats')->field('id,catname,catname2')->where('pid=0 and id<'.$fuzhuId.' and isstate=1')->order($this->config['order'])->select();
		$this->yiji = $yiji;
		$this->fuzhuId = $fuzhuId;
		UNSET($yiji,$fuzhuId);*/
	}

	public static function fuzhuid()
	{
		return M('news_cats')->where('catname="辅助栏目"')->getField('id');
	}

	public function head1($pid){

		$template = '<li %s><a href="%s">%s </a></li>';
		$data = $this->yiji;
		$cur = is_index() ? 'class="on"':'';
		$tmp = sprintf($template,$cur,'/','网站首页');
		foreach ($data as $key => $row) {
			$cur = $pid==$row['id'] ? 'class="on"':'';
			$url = getUrl(array('pid'=>$row['id']));
			$catname = $row['catname'];
			$tmp .= sprintf($template,$cur,$url,$catname);
		}
		ECHO $tmp;
		UNSET($template,$data,$tmp,$key,$row,$url,$catname);
	}




	//===========================//===========================//==============底部=======//===========================

/*
	public function foot2($pid=''){//导航形式2

		$tpl1 = '<li> <a href="%s">%s</a> <div class="erji"> <ul> %s </ul> </div> </li>';
	    $tpl2 = '<li><a href="%s">%s</a></li>';

	    $tmp1='';
		$data = $this->yiji;
		foreach ($data as $row) {
			$tmp2='';
			$pid = $row['id'];
			$yiji_url = getUrl(array('pid'=>$pid));
			$yiji_catname = $row['catname'];
			$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$pid.' and isstate=1')->order('disorder desc,id asc')->select();
			foreach ($erji as $erjiRow) {
				$ty = $erjiRow['id'];
				$erji_url = getUrl(array('pid'=>$pid,'ty'=>$ty));
				$erji_catname = $erjiRow['catname'];
				$tmp2 .= sprintf($tpl2,$erji_url,$erji_catname);
			}
			$tmp1 .= sprintf($tpl1,$yiji_url,$yiji_catname,$tmp2);
		}
		ECHO $tmp1;
		UNSET($tmp1,$tmp2,$cur,$data,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
	}*/

	public static function pc_nav2($pid=''){//导航形式2


		global $PHP_URL;
		$indexlclass = 'index.php' == $PHP_URL ? 'nav-active' : '';
		$pid = isset($pid) ? $pid : 0;
		$class=$temp='';//当前停留样式
		$tpl1 = ' <li class="headernav-li %s">
					  <a href="%s">
					    <p class="nav-English">%s</p>
					    <p class="nav-Chinese">%s</p>
					    <div class="banner-nav left-none">
					      <div class="nav-list flo_left">
					        <ul>
						        %s
					        </ul>
					      </div>
					      <div class="nav-img flo_right">
					        <img src="images/publication_01.png"/>
					      </div>
					    </div>
					  </a>
					</li>';
		$tpl1_1 = ' <li class="headernav-li %s">
					  <a href="%s">
					    <p class="nav-English">%s</p>
					    <p class="nav-Chinese">%s</p>
					  </a>
					</li>';
	    $tpl2 = '<li> <a title="%s" href="%s">%s</a> </li>';

	    $tmp1='';
		$navs = M('news_cats')->field('id,catname,catname2')->where('pid=0 and id<=8 and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($navs as $row) {
			$tmp2='';
			$thispid = $row['id'];
			$class = $thispid == $pid ? 'nav-active' : '';
			$yiji_url = getUrl(array('pid'=>$thispid));
			$yiji_catname = $row['catname'];
			$yiji_catname2 = $row['catname2'];
			if (in_array($thispid, array(3,4,7,8))) {
				$tmp1 .= sprintf($tpl1_1,$class,$yiji_url,$yiji_catname2,$yiji_catname);
			} else {

				$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$thispid.' and isstate=1')->order('disorder desc,id asc')->select();
				foreach ($erji as $erjiRow) {
					$ty = $erjiRow['id'];
					$erji_url = getUrl(array('pid'=>$thispid,'ty'=>$ty));
					$erji_catname = $erjiRow['catname'];
					$tmp2 .= sprintf($tpl2,$erji_catname,$erji_url,$erji_catname);
				}
				$tmp1 .= sprintf($tpl1,$class,$yiji_url,$yiji_catname2,$yiji_catname,$tmp2);
			}
		}
		echo '<li class="headernav-li ' . $indexlclass . '"> <a href="/"> <p class="nav-English">Home</p> <p class="nav-Chinese">首页</p> </a> </li>' . $tmp1;
		unset($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
	}







		/*function pc_nav2($pid=''){//导航形式2
			global $PHP_URL;
			$pid = isset($pid) ? $pid : 0;
			$class=$temp='';//当前停留样式
			$tpl1 = '<li class="yiji"> <a href="%s">%s</a> <div class="erji"> <dl> %s </dl> </div> </li>';
		    $tpl2 = '<dd><a href="%s">%s</a></dd>';

		    $tmp1='';
			$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<=4 and isstate=1')->order('disorder desc,id asc')->select();
			foreach ($navs as $row) {
				$tmp2='';
				// $pid = $row['id'];
				$yiji_url = getUrl(array('pid'=>$pid));
				$yiji_catname = $row['catname'];
				$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$pid.' and isstate=1')->order('disorder desc,id asc')->select();
				foreach ($erji as $erjiRow) {
					// $ty = $erjiRow['id'];
					$erji_url = getUrl(array('pid'=>$pid,'ty'=>$ty));
					$erji_catname = $erjiRow['catname'];
					$tmp2 .= sprintf($tpl2,$erji_url,$erji_catname);
				}
				$tmp1 .= sprintf($tpl1,$yiji_url,$yiji_catname,$tmp2);
			}
			ECHO ' <li style="margin-left: 0px;" class="yiji"> <a href="/" style="width:75px">首页</a> </li>'.$tmp1;
			UNSET($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
		}

		function pc_foot2($pid=''){//导航形式2
			global $PHP_URL;
			$pid = isset($pid) ? $pid : 0;
			$class=$temp='';//当前停留样式
			$tpl1 = '<ul> <li class="tdhzt"><a href="%s">%s</a></li> %s </ul>';
		    $tpl2 = '<li><a href="%s">%s</a></li>';

		    $tmp1='';
			$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<=4 and isstate=1')->order('disorder desc,id asc')->select();
			foreach ($navs as $row) {
				$tmp2='';
				$pid = $row['id'];
				$yiji_url = getUrl(array('pid'=>$pid));
				$yiji_catname = $row['catname'];
				$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$pid.' and isstate=1')->order('disorder desc,id asc')->select();
				foreach ($erji as $erjiRow) {
					$ty = $erjiRow['id'];
					$erji_url = getUrl(array('pid'=>$pid,'ty'=>$ty));
					$erji_catname = $erjiRow['catname'];
					$tmp2 .= sprintf($tpl2,$erji_url,$erji_catname);
				}
				$tmp1 .= sprintf($tpl1,$yiji_url,$yiji_catname,$tmp2);
			}
			ECHO $tmp1;
			UNSET($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
		}

		function wap_nav2($pid=''){
			global $PHP_URL;
			$pid = isset($pid) ? $pid : 0;
			$class=$temp='';//当前停留样式
			$tpl1 = '<dd class="clr"> <div class="dd_title dd_bg"><a href="javascript:void(0)" class="lt_yi_a">%s<i class="fr"></i></a></div> <div class="erji"> <dl> %s </dl> </div> </dd>';
		    $tpl2 = '<dd><a href="%s">%s</a></dd>';
		    $tmp1='';
			$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<=4 and isstate=1')->order('disorder desc,id asc')->select();
			foreach ($navs as $row) {
				$tmp2='';
				$pid = $row['id'];
				$yiji_url = getUrl(array('pid'=>$pid));
				$yiji_catname = $row['catname'];
				$erji = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$pid.' and isstate=1')->order('disorder desc,id asc')->select();
				foreach ($erji as $erjiRow) {
					$ty = $erjiRow['id'];
					$erji_url = getUrl(array('pid'=>$pid,'ty'=>$ty));
					$erji_catname = $erjiRow['catname'];
					$tmp2 .= sprintf($tpl2,$erji_url,$erji_catname);
				}
				$tmp1 .= sprintf($tpl1,$yiji_catname,$tmp2);
			}
			ECHO '<dd class="clr"> <div class="dd_title dd_bg"><a href="/" class="lt_yi_a">首页<i class="fr"></i></a></div></dd>'.$tmp1;
			UNSET($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
		}



	function pc_nav($pid=''){//导航形式1
		global $PHP_URL;
		$pid = isset($pid) ? $pid : 0;
		$class=$temp='';//当前停留样式
		$template = '<li><a href="%s">%s </a></li>';
		$tmp = sprintf($template,'/','网站首页');
		$fuzhuId = M('news_cats')->where('catname="辅助栏目"')->getField('id');
		$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<'.$fuzhuId.' and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($navs as $key => $row) {
			$url = getUrl(array('pid'=>$row['id']));
			$catname = $row['catname'];
			$tmp .= sprintf($template,$url,$catname);
		}
		ECHO $tmp;
		UNSET($cur,$navs,$row,$key,$class,$url,$temp,$catname,$template);
	}



	function pc_foot($pid=''){
		global $PHP_URL;
		$pid = isset($pid) ? $pid : 0;
		$class=$temp='';//当前停留样式
		$template = '<li><a href="%s">%s</a></li>';

		$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<=5 and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($navs as $key => $row) {
			$url = getUrl(array('pid'=>$row['id']));
			$catname = $row['catname'];
			$temp .= sprintf($template,$url,$catname);
		}
		ECHO '<li><a href="/">HOME</a></li>'.$temp.'<li class="ul"><a href="'.getUrl(array('pid'=>6)).'">CONTACT US</a></li>';
		UNSET($cur,$navs,$row,$key,$class,$url,$temp,$catname);
	}

	function wap_nav($pid=''){
		global $PHP_URL;
		$template = '<div class="left_menu clr"> <dl class="clr"> %s </dl> </div>';
		$pid = isset($pid) ? $pid : 0;
		$nav=$temp1='';
		$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<=6 and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($navs as $key => $row) {
			$temp1 = '<dd class="clr">
			            <div class="dd_title dd_bg"><a href="javascript:;" class="lt_yi_a">'.$row['catname'].'<i class="fr"></i></a></div>
			            <div class="erji">
			                <dl>
			                    %s
			                </dl>
			            </div>
			        </dd>';
			$navs2 = M('news_cats')->field('id,catname')->where('pid='.$row['id'].' and isstate=1')->order('disorder desc,id asc')->select();
			$temp2 = '';
			foreach ($navs2 as $val) {
				$url = getUrl(array('pid'=>$row['id']));
				$temp2 .= '<dd><a href="'.$url.'">'.$val['catname'].'</a></dd>';
			}
			$nav .= sprintf($temp1,$temp2);
		}
		ECHO sprintf($template,$nav);
		UNSET($template,$navs,$nav,$row,$key,$val,$temp1,$temp2);
	}*/

}
