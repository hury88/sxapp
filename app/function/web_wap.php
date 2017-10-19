<?php

function wap_nav($pid=''){
	$pid = isset($pid) ? $pid : 0;
	$temp=$class='';//当前停留样式
	$tpl = '<li><a href="%s">%s</a></li>';

	$navs = M('news_cats')->field('id,catname')->where('pid=0 and id<>5 and id<=6 and isstate=1')->order('disorder desc,id asc')->select();
	foreach ($navs as $key => $row) {
		$url = getUrl(array('pid'=>$row['id']));
		$catname = $row['catname'];
		$temp .= sprintf($tpl,$url,$catname);
	}
	ECHO '<li><a href="/">HOME</a></li>'.$temp;
	UNSET($cur,$navs,$row,$key,$class,$url,$temp,$tpl,$catname);
}

function wap_banner(){//BANNER 专用
	$ul1 = ' <div class="hd"> <ul> %s </ul></div>';
	$ul2 = ' <div class="bd"> <ul> %s </ul></div>';
	$temp1=$temp2='';
	$banners = M('news')->field('img1,linkurl')->where(array('pid'=>16,'ty'=>18,'isstate'=>1))->order('disorder desc,id asc')->select();
	foreach ($banners as $key => $bv) {//获取轮播图 轮播pid

		$link = empty($bv['linkurl']) ? '#' : $bv['linkurl'];
		$img = src($bv['img1']);
		$temp1 .= '<li><a target="_blank" href="'.$link.'"><img src="'.$img.'"/></a></li>';
		$temp2 .= '<li></li>';

	}
	ECHO sprintf($ul1,$temp1);
	ECHO sprintf($ul2,$temp2);
	UNSET($ul1,$ul2,$temp1,$temp2,$img,$link,$bv,$banners);
}



function buyCarFlow_wap2(){//购车流程
	$flows = HR('news')->field('img1,img2,ftitle,linkurl')->where('pid=1 and isstate=1')->order('isgood desc,disorder desc,id asc')->select();
	$temp='';
	if($flows){
		foreach ($flows as $key => $value) {
			$temp .= '<li>
			        	<div class="b-left"><img src="img/b'.($key+1).'.png" /></div>
			          <div class="b-right">
			          	<b>'.$value['ftitle'].'</b>
			            <p>'.$value['linkurl'].'</p>
			          </div>
			          <div class="clear"></div>
			        </li>';
		}
	}else{
		$temp = C('NO_CONTENT');
	}
	ECHO $temp;
	unset($right,$temp,$flows,$value,$key);

}


function buyCarFlow_wap(){//购车流程
	$flows = HR('news')->field('img1,img2,title,ftitle')->where('pid=1 and isstate=1')->order('isgood desc,disorder desc,id asc')->select();
	$temp='';
	if($flows){
		foreach ($flows as $key => $value) {
			$temp .= ' <div class="step1">
					    	<div class="main">
					        	<p class="font-s">'.$value['title'].'：'.$value['ftitle'].'</p>
					            <p>'.$value['linkurl'].'</p>
					            <div class="img">
					            	<img src="'.handelImg($value['img2']).'" />
					            </div>
					        </div>
					    </div>';
		}
	}else{
		$temp = C('NO_CONTENT');
	}
	ECHO $temp;
	unset($right,$temp,$flows,$value,$key);

}


function ensure_wap(){//服务保障
	$right='';
	$first = HR('news')->field('id,img1,title,ftitle')->where('pid=2 and tty=0 and isstate=1')->order('disorder desc,id asc')->select();
	if($first){
		foreach ($first as $key => $value) {
			extract($value);
			$img1 = handelImg($img1);
			$temp = '';

			$temp = '<div class="buy">
				    	<div class="title f_color">
				      	<span class="t-left"></span>
				        '.$title.'服务保障
				        <span class="t-right"></span>
				        <div class="clear"></div>
				      </div>
				      <div class="buy_main">
				         %FTITLE%
				         %LIST%
				      </div>
						%CONTENT%
				      <div class="bao">
				      	<img src="'.$img1.'" />
				      </div>
				    </div>';
			if(!empty($ftitle)) $temp = str_replace('%FTITLE%',' <i>'.$ftitle.'</i>',$temp);
			$second = HR('news')->field('title,content')->where("tty=$id and isstate=1")->order('disorder desc,id asc')->select();
			$list = '';
			foreach ($second as $key2 => $value2) {
				extract($value2);
				// $list .= '<div class="ppc clr"><span class="fl">'.($key2+1).'</span><p class="fl">'.$title.'</p></div>';
				$list .= '<p> <em>'.($key2+1).'</em> <span>'.$title.'</span> <div class="clear"></div> </p>';
				if(!empty($content))$content =preg_replace(array('/<p class="(.*?)">(.*?)<\/p>/'),array('<div class="kk">$2</div>'),preg_replace("/[\t\n\r]+/","",htmlspecialchars_decode($content) ));
				else $content='';
			}
			$temp = str_replace('%CONTENT%',$content,$temp);
			$right .= str_replace('%LIST%',$list,$temp);
		}
	}else{
		$right = C('NO_CONTENT');
	}

	ECHO str_replace(array('%FTITLE%','%CONTENT%'), '',$right);
	unset($first,$second,$right,$temp,$temp2,$title,$ftitle,$img1,$content);
}


function tojoin_wap(){//报名参团
	define('JOIN',true);
global $webarr;

	$where = array(
		'n1.ty'=>8,
		'n1.tty'=>0,
		'n1.isstate'=>1,
		'n1.pid'=>3,
		'n2.ty'=>14,

	);
	{//城市搜索
		$city = $_GET['city'];
		if(!empty($city)){
			$where['n1.file'] = array('like','%'.$city.'%');
		}else{
			$city = '';
		}

		/*foreach ($citylist as $key => $value_city) {
			$cityname = $value_city['title'];
			$cur = ($city==$cityname) ? ' on' : '';
			$cityString .= '<a class="city'.$cur.'" data-val="'.$cityname.'" href="javascript:void(0);">'.$cityname.'</a>';
		}*/
	}

	//通过城市  获取  城市所有的品牌

	            		//查询属于这个城市的品牌  城市  品牌

	//所有品牌
	// $allband = HR('news')->field('source,file,img5')->where('isstate=1 and ty=14 and tty=0 and pid=3')->group('source')->order(C('ORDER'))->select();
	// print_R($allband);

	$brandlist = '';
	$tools = import('Tools');
	$allband = HR('news')->alias('n1')->field('n2.source')->where($where)->join('right join '.C('DB_PREFIX').'news n2 ON n1.img5=n2.title')->group('n2.source')->select();
	foreach ($allband as $key => $value) {
		// if ($city && strpos($value['file'],$city) == 0 )continue;
		$suo = $value['source'];
		$wrap =
		 '<ul>
        	<li class="k_caption_li"><a id="go'.$suo.'" href="javascript:void(0);"></a>'.$suo.'</li>
        	%s
        </ul>';
		$brands = HR('news')->where("ty=14 and isstate=1 and source='$suo'")->select();//找到的品牌
		$temp = '';
		foreach ($brands as $bk => $bv) {
			if ($city) {
				$tools->set($bv['title'],$city);
				if(!$tools->isGroup())continue;
			}
		$temp .=
			'<li class="k_no_bor" >
            	<a title="'.$bv['title'].'" data-val="'.$bv['title'].'" href="javascript:void(0);">
                	<img alt="'.$bv['title'].'" width="50" height="50" src="'.handelImg($bv['img2']).'" class="k_a1"/>
                	<span>'.$bv['title'].'</span>
                </a>
            </li>';
		}
		if(empty($temp))$wrap='';
		$brandlist .= sprintf($wrap,$temp);
	}

	foreach ($webarr['ABC'] as $key => $abc) {
//		$brand .= '<li><a href="#go'.$abc.'">'.$abc.'</a></li>';
				$brand .= '<li><a href="javascript:void(0);">'.$abc.'</a></li>';
	}




	ECHO'
		<style>
		.k_caption_sel ul li a img{width:50px;height:50px;}
		.k_caption_sel>ul>li{height:25px;line-height:25px;padding:0;}
		.k_caption_sel>ul>.k_caption_li{
			background:#eeeeee;
			padding:5px 2%;
			color:#666666;
			border:0;
			}
		</style>
	';
/*<li class="k_ul_tit">选品牌</li>
          '.$brand.'*/
	ECHO
	'<div class="k_caption_sel">
    	'.$brandlist.'
        <div class="k_select" style="background:rgba(0,0,0,0);">
    	<ul>
    		<style> #smallChar{height:640px; } </style>
    		<script src="js/jquery-3.1.1.min.js"></script>
    		<script src="js/touch.js"></script>
	        <script>
    		$(\'#smallChar\')
    			  $(\'body\').seleChar({
                    callback:function(ret){
                    },
            });

			/*$(\'#smallChar\').on(\'click\',\'.chars\',function(){
				result = $(this).text();
				$("#bigChar").html(result)
				offsetTop = $(\'#go\'+result).offset().top;  //对应的是result
				$(\'html,body\').stop().animate({scrollTop:offsetTop});
			})*/
	        </script>

        </ul>
    </div>

    </div>';
	ECHO '<script>
  $(function(){
	 /* $(".k_select").on({
		  click : function(e){e.stopPropagation()},
		  mousemove: function(e){e.stopPropagation()},
		mouseover: function(e){e.stopPropagation()},
		  })*/
	  $(".k_select ul li").touchmove(function(e){
		  $("body").css({"overflow":"hidden"});
		  e.stopPropagation();
		  var tex=$(this).find("a").text();
		  $(".search").show();
		  $(".search").text(tex);

		  that = $("#go"+tex).offset();

//		 console.log(topX);
		   $("html, body").animate({scrollTop: that.top}).stop;
		  })

	  $(".k_select ul li").mouseout(function(){
		  $(".search").text();
		  $(".search").hide();

		  })
	  })

  </script>
	';
}


function getOrder($uid,$type='1'){
	if (empty($type)) {
		$map = array('uid'=>$uid);

	}else{
		$map = array('protocol'=>$type,'uid'=>$uid);

	}
	return M('order')->where($map)->order('sendtime desc,status asc')->select();
}

//品牌推广
function marketing($pagesize){
	// $carsBrand = HR('news')->field('id,hits,title,img1')->where('ty=14 and isstate=1 and isgood=1')->order(C('ORDER'))->select();
	$field = 'id,hits,title,img1';
	$where = array('ty'=>14,'isstate'=>1,'isgood'=>1);
	$temp = '';
	list($carsBrand,$pagestr) = get_page_list($field,$where,C('ORDER'),$pagesize);
	// _sql();
	// dump($carsBrand);
	foreach ($carsBrand as $key => $value) {
		$banner = handelImg($value['img1']);
		$symbol = handelImg($value['img2']);
		$url = getUrl(array('id'=>$value['id'],'invite'=>_gfv($_SESSION['userid'],'invitecode','user')),'show');
		$title = $value['title'];
		$temp .= '<div class="pro">
			    	<div class="pic">
			        	<a href="'.$url.'"><img src="'.$banner.'" /></a>
			        </div>
			    	<div class="name">
			        	<span><img src="'.$symbol.'" /></span>
			            <b>'.$title.'品牌团购会</b>
			            <a href="'.$url.'"><i>去推广</i></a>
			            <div class="clear"></div>
			        </div>

			    </div>';
	}
	ECHO $temp.$pagestr;
	UNSET($temp,$pagestr,$where,$field,$carBrand,$pagestr);
}


function g2($t,$c){
	// $i = (500-$t)/(40-$c);
	if ($c < 35) {
		$d = 480-$t;//剩余金额
		$min = $d;//剩余金额
		$l = 35-$c;//剩余数
		$avg = floor($d/$l);//当前平均值
		$arr = array();
		for ($i=0; $i < $l/2; $i++) {
			$rand = mt_rand(0,floor($avg/2));
			array_push($arr,$avg+$rand,$avg-$rand);
		}
		 shuffle($arr);
		return array_shift($arr);
	}elseif($c == 35){
		return 20;
	}elseif($t < 997){//> 40
		return ( mt_rand(2,3) );
	}
}


 ?>
