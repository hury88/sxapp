<?php
class Search
{
    public static $Temp = [];

    public $q = '';
    public $data = [];
    public $paging = '';
    public $totalRows = 0;

    public function __construct($q='')
    {
        $map = m_gWhere(4,11);
        if ($q) {
            $where = [
                'introduce' => ['like','%'.$q.'%'],
                'content' => ['like','%'.$q.'%'],
                'title' => ['like','%'.$q.'%'],
                '_logic' => 'or',
            ];
            $map['_complex'] = $where;
            $this->q = $q;
        }
        $pageConfig = [
            'where' => $map,//条件
            'field' => 'id,title,sendtime,img1,introduce',//表
        ];
        list($this->data, $this->paging, $this->totalRows) = pagenation($pageConfig);
    }
	public function index()
	{
        $list = '';
        $data = $this->data;
		foreach ($data as $value) {
    		extract($value);
    		$img1 = src($img1);$url = U('news/detail', ['id'=>$id]);
    		$d1 = date('m-d',$sendtime);
    		$d2 = date('Y',$sendtime);
            $h4 = str_replace($this->q, '<b style="color:red">'.$this->q.'</b>',$title);
            $intro = str_replace($this->q, '<b style="color:red">'.$this->q.'</b>',$introduce);
    		$list .= <<<T
                <li class="search-li">
                    <a href="$url" title="$title">
                        <div class="search-L fl">
                            <img alt"$introduce" src="$img1"/>
                        </div>
                        <div class="search-R fr">
                            <div class="news-title">
                                <h4 class="fl">$h4</h4>
                                <div class="fr news-time">
                                    <p>$d1</p>
                                    <span>$d2</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="news-intro">
                               $intro
                            </div>
                        </div>
                        <div class="clear"></div>
                    </a>
                </li>
T;
		}
        $list or $list = config('other.nocontent');
        $this->display = $list;
		return $list;
	}

    public function __get($key)
    {
        return isset(self::$Temp[$key]) ? htmlspecialchars_decode( self::$Temp[$key] ) : '';
    }

    public function __set($key, $value)
    {
        self::$Temp[$key] = $value;
    }

}
