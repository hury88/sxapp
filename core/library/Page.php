<?php
/* +----------------------------------------------------------------------
*  hury 2017年5月7日14:28:38
*  +----------------------------------------------------------------------
*  ajax分页  前后端 区分
*  +----------------------------------------------------------------------
*/

class Page{
    public $firstRow; // 起始行数
    public $listRows; // 列表每页显示行数
    public $parameter; // 分页跳转时要带的参数
    public $totalRows; // 总行数
    public $totalPages; // 分页总页面数
    public $rollPage   = 15;// 分页栏每页显示的页数
	public $lastSuffix = true; // 最后一页是否显示总页数

    public $data = array();//分页后的数据

    private $p       = 'page'; //分页参数名
    private $url     = ''; //当前链接URL
    private $nowPage = 1;

	// 分页显示定制
    private $config  = array(
        'header' => '<span class="rows">共 %TOTAL_ROW% 条记录</span>',
        'prev'   => '上一页',
        'next'   => '下一页',
        'first'  => '首页',
        'last'   => '共%TOTAL_PAGE%页',
        'theme'  => '%TOTAL_PAGE% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
        'style'  => 'href',
        'field'  => '*',
    );


    /**
     * [DEMO]
     * +$pageConfig = array(
     * +    'where' => $map,//条件
     * +    'order' => 'creattime desc',//排序
     * +    'psize' => 5,//条数
     * +    'table' => $table,//表
     * +    'style' => 'href',//表
     * +);
     */
    public static function paging($pageConfig,$method='show_back'){
        $page = new Page($pageConfig);
        $data = $page->data;
        $pagestr = $page->$method();
        $totalRows = $page->totalRows;
        UNSET($page);
        return array($data,$pagestr,$totalRows);
    }

    public function __construct($config){
        // C('VAR_PAGE') && $this->p = C('VAR_PAGE'); //设置分页参数名称
        $this->nowPage   = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
       /* if(isset($config['style']) && $config['style']=='data-page'){
            $this->nowPage   = empty($_POST[$this->p]) ? 1 : intval($_POST[$this->p]);
        }*/
        $this->nowPage   = $this->nowPage>0 ? $this->nowPage : 1;
        $this->config = array_merge($this->config,$config);

        $this->init();
    }

    /**
     * URL组装 支持不同URL模式
     * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
     * @param string|array $vars 传入的参数，支持数组和字符串
     * @param string|boolean $suffix 伪静态后缀，默认为true表示获取配置值
     * @param boolean $domain 是否显示域名
     * @return string
     */
    public static function U($url='',$vars='',$suffix=true,$domain=false)
    {
        //获取当前页地址
        if(empty($url)){
            $urlArr = queryString(1,0);
            $urlArr = array_merge($urlArr,$vars);
            return $_SERVER['SCRIPT_NAME'].'?'.http_build_query($urlArr);
        }


    }

    /**
     * 架构函数
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function init() {
        /* 生成URL */
        $this->url = Page::U('', array($this->p=>'[PAGE]'));
        list($this->totalRows, $this->data) = $this->model();
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if(! empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

    }

    //根据传入的配置信息,获取数据
    public function model(){
        $table = $this->config['table'];
        $where = $this->config['where'];
        $order = $this->config['order'];
        $field = $this->config['field'];
        $psize = $this->listRows = $this->config['psize'];
        $nowPage = $this->nowPage;
        $count = M($table)->where($where)->count();
        $data  = M($table)->field($field)->where($where)->order($order)->limit(($nowPage-1)*$psize,$psize)->select();
        $data or $data=array();
        return array($count,$data);
    }


    /**
     * 定制分页链接设置
     * @param string $name  设置名称
     * @param string $value 设置值
     */
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }


    /**
     * 生成链接URL
     * @param  integer $page 页码
     * @return string
     */
    private function url($page){//链接形式
        return str_replace(urlencode('[PAGE]'), $page, $this->url);
    }

    public function show_front_lazy(){
        if(0 == $this->totalRows) return '';
        $this->rollPage = 10;
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<div class="load clearfix" onclick="giveMeMore('.$down_row.')"><a href="javascript:;" '.$this->config['style'].'='.$this->parse_pagnation($down_row).'>向下拉加载更多</a> </div>' : '<div class="load clearfix"><a href="javascript:;">It\'s over.</a></div>';
        $this->config['theme'] = '%DOWN_PAGE%';
        //替换分页内容
        $page_str = str_replace(
            array('%DOWN_PAGE%'),
            array($down_page),
            $this->config['theme']);
        return $page_str;
    }
    public function show_front(){
        if(0 == $this->totalRows) return '';
        $this->rollPage = 10;
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a class="" '.$this->config['style'].'='.$this->url($up_row).'>' . $this->config['prev'] . '</a>' : '<a>' . $this->config['prev'] . '</a>';

        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a class="" '.$this->config['style'].'='.$this->url($down_row).'>'.$this->config['next'].'</a>' : '';

        //第一页
        $the_first = '';
        if($this->totalPages >= $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = '<a class=""  '.$this->config['style'].'='.$this->url(1).'>' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = '<a class="" '.$this->config['style'].'='.$this->url($this->totalPages).'>' . $this->config['last'] . '</a>';
        }

        //数字连接
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
            if(($this->nowPage - $now_cool_page) <= 0 ){
                $page = $i;
            }elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
                $page = $this->totalPages - $this->rollPage + $i;
            }else{
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= '<a class=" " '.$this->config['style'].'='.$this->url($page).'>'. $page . '</a>';
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 0){//当前页
                    $link_page .= '<a class="pager-now" '.$this->config['style'].'='.$this->url($page).'>' . $page . '</a>';
                }
            }
        }
        $this->config['theme'] = '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%';
        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
            array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages),
            $this->config['theme']);
        return $page_str;
    }

    private function parse_pagnation($pages)
    {
        global $requestUri,$controller,$method;
        $_GET[$this->p] = $pages;
        $uri = U("$controller/$method", $_GET);
        return $uri;
    }

    /**
     * [show_front_mvc_pc mvc 链接跳转]
     * @return [type] [description]
     */
    public function show_front_mvc_pc(){
        if(0 == $this->totalRows) return '';
        $this->rollPage = 10;
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        $style = $this->config['style'];
        $tpl_up_page   = '<a style="width:85px" '.$style.'="%s">'.config('translator.page')['prev'].'</a>';//上一页
        $tpl_down_page = '<a '.$style.'="%s">'.config('translator.page')['next'].'</a>';//下一页
        $tpl_the_first = '<a '.$style.'="%s">'.config('translator.page')['first'].'</a>';//第一页
        $tpl_the_end   = '<a '.$style.'="%s">'.config('translator.page')['last'].'</a>';//最后一页
        $tpl_link_page = '<a '.$style.'="%s">%s</a>';//数字连接
        $tpl_on_page = '<a class="on" '.$style.'="%s">%s</a>';//当前页

        //上一页
        $up_row  = $this->nowPage - 1;

        $up_page = $up_row > 0 ? sprintf($tpl_up_page, $this->parse_pagnation($up_row)) : sprintf($tpl_up_page, 'javascript:void(0);');


        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? sprintf($tpl_down_page, $this->parse_pagnation($down_row)) : sprintf($tpl_down_page, 'javascript:void(0);');

        //第一页
        $the_first = '';
        if($this->totalPages >= $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = sprintf($tpl_the_first, $this->parse_pagnation(1));
        }

        //最后一页
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = sprintf($tpl_the_end, $this->parse_pagnation($this->totalPages));
        }

        //数字连接
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
            if(($this->nowPage - $now_cool_page) <= 0 ){
                $page = $i;
            }elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
                $page = $this->totalPages - $this->rollPage + $i;
            }else{
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= sprintf($tpl_link_page, $this->parse_pagnation($page), $page);
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 0){//当前页
                    $link_page .= sprintf($tpl_on_page, $this->parse_pagnation($page), $page);
                }
            }
        }

        // $this->config['theme'] = '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%';
        $this->config['theme'] = '<p class="zizhiP pc" style="padding: 30px 0;width: 40%;margin: 0 auto;overflow:hidden;">%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%</p>';
        $this->config['theme2'] = '<p class="zizhiP sj" style="padding: 15px 0;width: 45%;margin: 0 auto;overflow:hidden;">%UP_PAGE% %DOWN_PAGE%</p>';
        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
            array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages),
            $this->config['theme']);
        $page_str2 = str_replace(
            array('%UP_PAGE%', '%DOWN_PAGE%'),
            array($up_page, $down_page),
            $this->config['theme2']);
        return ['pc' => $page_str, 'wap' => $page_str2];
    }

    /**
     * [show_front_m 手机端 mvc 链接跳转]
     * @return [type] [description]
     */
    public function show_front_m(){
        if(0 == $this->totalRows) return '';
        $this->rollPage = 10;
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a class="dev" '.$this->config['style'].'='.$this->parse_pagnation($up_row).'>' . $this->config['prev'] . '</a>' : '<a href="javascript:void(0);">' . $this->config['prev'] . '</a>';


        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a class="dev" '.$this->config['style'].'='.$this->parse_pagnation($down_row).'>'.$this->config['next'].'</a>' : '<a href="javascript:void(0);">'.$this->config['next'].'</a>';

        $this->config['theme'] = '%UP_PAGE% %DOWN_PAGE%';
        //替换分页内容
        $page_str = str_replace(
            array('%UP_PAGE%', '%DOWN_PAGE%'),
            array($up_page, $down_page),
            $this->config['theme']);
        return $page_str;
    }

    /**
     * [show_front_m 手机端 mvc ajax跳转]
     * @return [type] [description]
     */
    public function show_front_mvc_ajax(){
        // /index.php/produce/index/type/3/batch/1/page/2
        if(0 == $this->totalRows) return '';
        $this->rollPage = 10;
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a class="" '.$this->config['style'].'='.$this->parse_pagnation($up_row).'>' . $this->config['prev'] . '</a>' : '<a href="javascript:void(0);">' . $this->config['prev'] . '</a>';


        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a class="" '.$this->config['style'].'='.$this->parse_pagnation($down_row).'>'.$this->config['next'].'</a>' : '<a href="javascript:void(0);">'.$this->config['next'].'</a>';

        $this->config['theme'] = '%UP_PAGE% %DOWN_PAGE%';
        //替换分页内容
        $page_str = str_replace(
            array('%UP_PAGE%', '%DOWN_PAGE%'),
            array($up_page, $down_page),
            $this->config['theme']);
        return $page_str;
    }


    public function show_back(){
        if(0 == $this->totalRows) return '';
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a class="fl" '.$this->config['style'].'='.$this->url($up_row).'>' . $this->config['prev'] . '</a>' : '';

        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a class="fl" '.$this->config['style'].'='.$this->url($down_row).'>'.$this->config['next'].'</a>' : '';

        //第一页
        $the_first = '';
        if($this->totalPages >= $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = '<a class="fl"  '.$this->config['style'].'='.$this->url(1).'>' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = '<a class="end" '.$this->config['style'].'='.$this->url($this->totalPages).'>' . $this->config['last'] . '</a>';
        }

        //数字连接
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
            if(($this->nowPage - $now_cool_page) <= 0 ){
                $page = $i;
            }elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
                $page = $this->totalPages - $this->rollPage + $i;
            }else{
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= '<a class="fl" '.$this->config['style'].'='.$this->url($page).'>'. $page . '</a>';
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 0){//当前页
                    $link_page .= '<a class="fl" '.$this->config['style'].'='.$this->url($page).'>' . $page . '</a>';
                }
            }
        }

        $link_page .= "<select class=\"fl\" onChange='javascript:location=this.options[this.selectedIndex].value;'>\n";
        for($i=1;$i<=$this->totalPages;$i++){
            if($i==$this->nowPage) $s="selected";else $s="";
            $link_page=$link_page."<option value=\"".$this->url($i)."\"{$s}>{$i}</option>\n";
        }
        $link_page.="</select>\n";

        //替换分页内容
    $this->config['theme']  =   <<<PAGE
<div class="fr fanye">
    <span class="fl">第%NOW_PAGE%/%TOTAL_PAGE%页</span>
    <span class="fl">共%TOTAL_ROW%条记录</span>
    %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%
</div>
PAGE;
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
            array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages),
            $this->config['theme']);
        return $page_str;
    }


}
