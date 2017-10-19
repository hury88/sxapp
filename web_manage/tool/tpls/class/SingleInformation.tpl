<?php
// 单条信息
class SingleInformation
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
		$list = $pagestr = '';

		if (! $ti) {
			$networks = v($pid,$ty,'<li><a data-id="%$id%" href="javascript:;">%$title%</a></li>');
			$tx = self::getFirstTi($pid,$ty);
					// $firstTi = Program::getFirstTi();
echo <<<T
	<ul class="recFilm clr">
		$networks
	</ul>
	<script>
		$(".recFilm li").eq(0).addClass("curr")
		$(".recFilm li a").click(function(){
			$(this).parent("li").addClass("curr").siblings("li").removeClass("curr")
			ti = $(this).data("id")
			$.getJSON("/ModelProgram/?ti=" + ti,function(json){
				$(".stills ul,.work ul").html(json[0])
				$("ul#page_list").html(json[1])
			})
		});
		$.getJSON("/ModelProgram/?ti=$tx",function(json){
			$(".stills ul,.work ul").html(json[0])
			$("ul#page_list").html(json[1])
		});
		$(document).on("click","ul#page_list li a",function(){
			href = $(this).data("href");
			pattern = /\/ti\/(.*)\/page\/(.*)/
			r = pattern.exec(href)
			ti = r[1]
			page = r[2]

			$.getJSON("/ModelProgram/?ti="+ti+"&page="+page,function(json){
				$(".stills ul,.work ul").html(json[0])
				$("ul#page_list").html(json[1])
			})
		})
	</script>
T;
		}

		$ti or $ti = self::getFirstTi($pid,$ty);


		if ($ti) {
			$where = ['ti'=>$ti];
	    	$pageConfig = [
		        'table' => 'pic',//条件
		        'where' => $where,//条件
		        'order' => 'disorder desc,id asc',
		        'field' => 'id,title,img1,img2',//表
		        'psize' => '8',//条数
		        'style' => 'data-href',
		    ];
		    list($data, $pagestr, $totalRows) = self::data($pageConfig);
			// $pagestr = str_replace('news/index', 'news/_list', $pagestr);
			foreach ($data as $key => $value) {
	    		extract($value);
	    		$img1 = src($img1);
	    		$img2 = $img2 ? src($img2) : $img1;
	    		// $url = U('news/detail', ['id'=>$id]);
	    		$list .= <<<T
<li>
    <a href="$img2" title="$title" rel="store_shop">
        <img src="$img1" alt="" width="214" height="301">
    </a>
    <p>
        <a href="$img2" title="$title" rel="store_2">$title</a>
    </p>
</li>
T;
			}
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
