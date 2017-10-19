<?php
class Index
{
	public static $data = [];// 当前类型信息

	public function __construct()
	{
		#首页配置
		$find = M('news')->field('img1,img2,content2,content3,source')->where(m_gWhere(7,-26))->find();
		$this->img1 = src( $find['img1'] );
		$this->img2 = src( $find['img2'] );
		$this->content2 = $find['content2'];
		$this->content3 = $find['content3'];
		$this->filmflower = $find['source'];
		$this->news = $this->news();
		$this->movie = $this->movie();
		$this->program = $this->program();
		/*
		$find = M('news')->field('linkurl,img1,img2,img3')->where(m_gWhere(10,-25))->find();
		$this->linkurl = v_news(10,-25,'linkurl');  // 广告链接
		$this->img1 = src( v_news(10,-25,'img1') ); // 广告图
		$img2 = src( v_news(10,-25,'img2') ); // 新闻小图
		$this->img3 = src( v_news(10,-25,'img3') ); // 新闻大图

		$this->banner(10, 21);
		$this->dingzhi();
		$this->moreDingzhi = MU(2);
		$this->moban = $this->moban();
		$this->moreMoban = MU(1);
		$this->moreNews = MU(8);
		$this->moreIndustry = MU(9);
		#主要客户
		$this->partner = $this->partner();
		#置顶新闻
		$this->topNews = $this->news($img2);*/


	}


	public function nav(){//moan
		$data  = M('news_cats')->where('pid=1 and isstate=1')->order('disorder desc, id asc')->getField('catname',true);
		$tmp = '';
		foreach ($data as $ckey => $chunk) {
		$list = '';
		}
		unset($data,$func,$list,$ckey,$chunk,$key,$value,$img1,$img2);
		return $tmp;
	}

	public function movie(){//moan
		$data  = M('news')->field('id,pid,title,img1')->where('pid =3 and ty<>23 and isstate=1')->order(config('other.order'))->limit(10)->select();

		$tmp = '';
		$data = array_chunk($data, 5);
		foreach ($data as $ckey => $chunk) {
		$list = '';
		foreach ($chunk as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<T
<li>
	<a href="$U"><img src="$img1" alt="" width="186" height="262"></a>
	<p>
		<a href="$U">$title</a>
	</p>
</li>
T;
		}
		// $style = $ckey == 1 ? ' style="margin-top: 28px;"' : '';
		$tmp .= <<<T
<div class="item">
	<ul class="movie clr">
	$list
	</ul>
</div>
T;
		}
		unset($data,$func,$list,$ckey,$chunk,$key,$value,$img1,$img2);
		return $tmp;
	}

	public function program(){//moan
		$where = m_gWhere(4,11);
		$data  = M('news')->field('id,pid,title,img1')->where($where)->order(config('other.order'))->limit(10)->select();

		$tmp = '';
		$data = array_chunk($data, 5);
		foreach ($data as $ckey => $chunk) {
		$list = '';
		foreach ($chunk as $key => $value) {
    		extract($value);
    		$img1 = src($img1);
    		$U = U($pid.'/detail', ['id'=>$id]);
    		$list .= <<<T
<li>
	<a href="$U"><img src="$img1" alt="" width="186" height="262"></a>
	<p>
		<a href="$U">$title</a>
	</p>
</li>
T;
		}
		// $style = $ckey == 1 ? ' style="margin-top: 28px;"' : '';
		$tmp .= <<<T
<div class="item">
	<ul class="movie clr">
	$list
	</ul>
</div>
T;
		}
		unset($data,$func,$list,$ckey,$chunk,$key,$value,$img1,$img2);
		return $tmp;
	}


	public function news()
	{
		$data = M('news')->field('id,title,introduce,img1,name,sendtime')->where('pid=2 and isstate=1 and istop=1')->limit(6)->select();
		$list = '';
		foreach ($data as $key => $value) {
			extract($value);
			$U = U('2/detail',['id'=>$id]);
			if ($key == 0) {
				$time = date('Y-m-d',$sendtime);
				$intro = cutstr($introduce,55);
				$img1 = src($img1);
				$list .= <<<T
<li class="top">
	<a class="photo" title="$title" href="$U"><img src="$img1" alt="" width="150" height="89"></a>
	<h4><a title="$title" href="$U">$title</a></h4>
	<span class="info">发布者：$name&nbsp;&nbsp;&nbsp;&nbsp;日期：$time</span>
	<p>
		<a href="$U">$intro</a>
	</p>
</li>
T;
			} else {

			$list .= <<<T
<li>
	<p>
		<a title="$title" href="$U">$title</a>
	</p>
</li>
T;
			}
		}
		unset($data,$key,$value,$title,$introduce,$img1,$U,$intro,$time,$sendtime);
		return $list;
	}






	public function __get($key)
	{
		echo isset(self::$data[$key]) ? self::$data[$key] : '';
	}

	public function __set($key, $value)
	{
		self::$data[$key] = $value;
	}

}
