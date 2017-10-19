<?php
//这里放全局的函数 by hury
if(!defined('_IMPORT_')){
    define('_IMPORT_',dirname(dirname(dirname(__FILE__))));
}

function m_gWhere($pid,$ty=0){
    $map = array('pid'=>$pid,'ty'=>$ty,'isstate'=>1);
    if ($ty===-1) UNSET($map['ty']); //-1时代表ty不加入条件中
    return $map;
}//生成条件数组


function postMsg($codeTemp, $phone){
    // $codeTemp =  '【上团汽车】您的验证码是'.$_SESSION['yzm'].',1分钟内有效.若非本人操作请忽略此消息。';
    $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
    $smsapi = "http://www.smsbao.com/"; //短信网关
    $user = "shangtuan"; //短信平台帐号
    $pass = md5("aini1wannian"); //短信平台密码
    $content='【上团汽车】'.$codeTemp;//要发送的短信内容
    $phone = $phone;
    $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
    $result =file_get_contents($sendurl) ;
    if($result == 0)
        return true;
    else
        return $statusStr[$result];

}


function ajaxReturn($status,$msg,$dom=false){
    $arr = array();
    $arr['status'] = $status;
    $arr['msg'] = $msg;
    if($dom)$arr['dom']=$dom;
    echo json_encode($arr);
    unset($arr,$status,$msg,$dom);
    exit;
}

/**
 * time : 2017年4月28日13:20:24
 * 判断 时间是否有效
 * 0:过期
 */
function dateCompare($tox,$toy=''){
   return strtotime(date('Y-m-d H:i:s',$tox).$toy) < time() ? 0 : 1;
}

/**
 * [R 自动加载类库]
 * @param string $class [类名称]
 * @param [type] $arg   [有参构造函数]
 * @return 返回类的实例
 */
function import($class='',$arg=null,$import=false){
    $file = _IMPORT_.'/'.$class.'.class.php';
    if(is_file($file)){
        include_once $file;
        if(strpos(ltrim($class,'/'),'/')){
            $class = end(explode('/',$class));
        }
        if($import)return true;//只加载不实例化

        if(is_null($arg)){
            $instance = new $class();
        }else{
            $instance = new $class($arg);
        }
        return $instance;
    }
    E(LogRecord("[ 库不存在 ] $file"));

}

/**
 * 获取随机数
 * {DEMO}
 * +$icode = getCode();
 * +$findCode = M('user')->where(array('invitecode'=>$icode))->find();
 * +while($findCode){
 * +    $icode = getCode();
 * +    $findCode = M('user')->where(array('invitecode'=>$icode))->find();
 * +}
 * +$info['invitecode'] = $icode;//生成邀请码
 */
define('GETCODE_NUMBER', 1);
define('GETCODE_MIX', 2);
function getCode($num = 4, $type=GETCODE_MIX){
    if ($type == GETCODE_MIX) {
        $str = "1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";      //要显示的字符，可自己进行增删
    } elseif($type == GETCODE_NUMBER){
        $str = "1,2,3,4,5,6,7,8,9,0";      //要显示的字符，可自己进行增删
    }
    $list = explode(",", $str);
    $cmax = count($list) - 1;
    $verifyCode = '';
    for ( $i=0; $i < $num; $i++ ){
          $randnum = mt_rand(0, $cmax);
          $verifyCode .= $list[$randnum];           //取出字符，组合成为我们要的验证码字符
    }
    return $verifyCode;        //将字符放入SESSION中

}

/**
 * [array_sort description]
 * @param  [type] &$arrUsers [description]
 * @param  [type] $field     [description]
 * @param  string $direction [description]
 * @return [type]            [description]
 * [demo]
 *+$sort = array(
 *+        'direction' => $direction, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 *+        'field'     => $field,       //排序字段
 *+);
 *+
 *+$arrSort = array();
 *+foreach($arrUsers AS $uniqid => $row){
 *+    foreach($row AS $key=>$value){
 *+        $arrSort[$key][$uniqid] = $value;
 *+    }
 *+}
 *+ print_r($arrSort);
 *+if($sort['direction']){
 *+    // array_multisort($arrSort[$sort['field']], constant($sort['direction']),$arrSort['id'],SORT_ASC ,$arrUsers);
 *+    array_multisort($arrSort[$sort['field']], constant($sort['direction']),$arrUsers);
 *+}
 *+return $data;
 */
function array_sort(&$data,$field,$direction='SORT_DESC'){
    $arrSort = array();
    foreach($data AS $key => $row){
             $arrSort[$field][$key] = $row[$field];
    }
    array_multisort($arrSort[$field], constant($direction),$data);
    return $data;
}

//根据key给二维数组进行分组
function array_group($arr,$field){
    $arrGroup = array();
    foreach($arr AS $key => $row){
        $arrGroup[$row[$field]][] = $row;
    }
    unset($arr);
    return $arrGroup;
}

//将数组用某个函数处理
function array_walk_decode(&$value,$key){
    $value = htmlspecialchars_decode($value,ENT_QUOTES);
}

//将数组用某个函数处理
function array_walk_func(&$value,$key,$func){
    $value = $func($value);
}


//2017年4月5日01:19:14 新+
//获取地址栏目参数
//0: 返回字符串  1:返回数组
//false: 保留id  true:剔除id
function queryString($type=0,$id=false){
    $urlArgs = explode('&',trim($_SERVER['QUERY_STRING'],'&'));
    $realArgs = array();
    foreach ($urlArgs as $key => $value) {//排除重复参数
        if (strpos($value,'=')) {
            list($k,$v) = explode('=',$value);
            if($id && $k=='id')continue;
            $realArgs[$k] = rawurldecode($v);
        }
    }
    unset($urlArgs,$key,$value,$k,$v);
    return $type ? $realArgs : http_build_query($realArgs);
}

/* 控制值的长度(原函数)
 + ***********
 + //更新时间 2017年4月4日21:59:24
 + ***********
 + 截取字符串(改进之后)
 + ***********
*/
function cutstr($str, $length=20,$subfix='…',$start=0, $charset='utf-8')
{
    $str = strip_tags( htmlspecialchars_decode($str) );
    if(function_exists('mb_substr')){
        $substr = mb_substr($str, $start, $length, $charset);
        return mb_strlen($str,$charset) > $length ? $substr.$subfix: $substr;
    }elseif(function_exists('iconv_substr')) {
        $substr = iconv_substr($str, $start, $length, $charset);
        return iconv_strlen($str,$charset) > $length ? $substr.$subfix: $substr;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join('',array_slice($match[0], $start, $length));
    return count($match[0]) > $length ? $slice.$subfix : $slice;
}


//处理图片
function src($img,$path='upload',$nopic='nopic'){
    global $system_siteurl;
    $upload =  Config::get("pic.$path");
    $imgPath = ROOT_PATH . $upload .$img;
    if(empty($img) || !file_exists($imgPath)){
        $img = Config::get("pic.$nopic");
    } else {
        $img = $upload . $img;
    }
    return Request::instance()->domain() . $img;
}

//获取系统信息表 某个字段值
function getConfig($feild){
    return M('config')->getField($feild);
}


//调试sql
function  _sql(){
    echo current(Config::get('HR'))->getLastSql();
}


/**
 * [CURLSend 使用curl向服务器传输数据]
 * @param [type] $url  [请求的地址]
 * @param array  $data [数据]
 * @param string $type [请求方式GET,POST]
 */
function CURLSend($url, $method='get', $data=array()) {
	$data = http_build_query($data);

    $ch = curl_init();//初始化
    $headers = array('Accept-Charset: utf-8');
    //设置URL和相应的选项
    curl_setopt($ch, CURLOPT_URL, $url);//指定请求的URL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));//提交方式
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//不验证SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//不验证SSL
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置HTTP头字段的数组
    // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible;MSIE 5.01;Windows NT 5.0)');//头的字符串
    #curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
    #curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);//自动设置header中的Referer:信息
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//提交数值
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//是否输出到屏幕上,true不直接输出
    $temp = curl_exec($ch);//执行并获取结果
    curl_close($ch);
    return $temp;//return 返回值
}

//生成url
function getUrl($args,$php='list'){
    if(C('REWRITE')){
        $suf = 'html';
    }else{
        $suf = 'php';
    }
    $strToArg = '';
    if(is_array($args)){

        foreach ($args as $key => $value) {

            if (!$value) {continue; }

            $strToArg .= '&'.$key.'='.$value;
        }
    }else{
        $args = intval($args);
        $strToArg = "&id=$args";
    }
    if($php){
        $url = $php.'.'.$suf;
    }else{
        $url = '';
    }
    if($strToArg){
        $strToArg = substr($strToArg,1);
        $url .= '?'.$strToArg;
    }
    unset($php,$strToArg,$suf);
    return $url;
}



function v_news_list($pid,$ty,$field='*', $limit=0){
    $m = M('news')->where(array('pid'=>$pid,'ty'=>$ty,'isstate'=>1))->order(Config::get('other.order'));
    if ( count( explode(',',$field) ) == 2) {
        $data = $m->getField($field);
    } else {
        if ($limit) {
            $data = $m->field($field)->limit($limit)->select();
        } else {
            $data = $m->field($field)->select();
        }
    }
    return $data;
}

function v_list($table, $field = '*', $where = [], $limit=0){
    $where['isstate'] = 1;
    $m = M($table)->field($field)->where($where)->order(Config::get('other.order'));
    if ($limit) {
        $m = $m->limit($limit);
    }

    $data = $m->select();

    return $data;
}
function v_id($id,$field='',$table='news')
{
    if ($field) {
        return M($table)->where("`id`=$id")->getField($field);
    } else {
        return M($table)->find($id);
    }
}
//为了获取方便增加 查询news表函数
function v_news($pid,$ty,$field){
    $fieldValue = M('news')->where(array('pid'=>$pid,'ty'=>$ty))->getField($field);
    return strpos($field, 'content') !== false ? htmlspecialchars_decode($fieldValue) : $fieldValue;
}
//为了获取方便增加 查询news_cats表函数
function v_news_cats($id,$field){
    return M('news_cats')->where(array('id'=>$id))->getField($field);
}
//获取 某个表的某一行的某个字段值
function getFieldValue($id,$field='catname',$table='news_cats'){
    $where = array('isstate'=>1);
    if(is_array($id)){
        $where = array_merge($where,$id);
        $HR = HR($table)->field($field)->where($where)->find();
    }else{
        $HR = HR($table)->field($field)->where($where)->find($id);

    }
    if($HR){
        $HR = $HR[$field];
    }else{
        $HR = false;
    }
    unset($field,$where,$table,$id);
    return $HR;
}

function is_get(){
    return 'GET' == strtoupper($_SERVER['REQUEST_METHOD']) ? TRUE : FALSE;
}

function is_post(){
    return 'POST' == strtoupper($_SERVER['REQUEST_METHOD']) ? TRUE : FALSE;
}

function is_index(){
    global $PHP_URL;
    return 'index' == pathinfo($PHP_URL,PATHINFO_FILENAME) ? TRUE : FALSE;
}


//增加日志文件

function AddLog($_logcontent,$_logname) {

    global $PHP_TIME,$PHP_IP;
    $data = array(
        'username'  =>  $_logname,
        'content'   =>  $_logcontent,
        'ip'        =>  $PHP_IP,
        'sendtime'  =>  $PHP_TIME,
    );
    M('logs')->insert($data);
}



/**
* 判断访问者是不是robot
*/
function getrobot() {
    if(!defined('IS_ROBOT')) {
        $kw_spiders = 'Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla';
        $kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            if(preg_match("/($kw_browsers)/", $_SERVER['HTTP_USER_AGENT'])) {
                define('IS_ROBOT', FALSE);
            } elseif(preg_match("/($kw_spiders)/", $_SERVER['HTTP_USER_AGENT'])) {
                define('IS_ROBOT', TRUE);
            } else {
                define('IS_ROBOT', FALSE);
            }
        } else {
            define('IS_ROBOT', FALSE);
        }
    }
    return IS_ROBOT;
}

//通过ip获取城市
function GetIp(){
    $realip = '';
    $unknown = 'unknown';
    if (isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach($arr as $ip){
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
            $realip = $_SERVER['REMOTE_ADDR'];
        }else{
            $realip = $unknown;
        }
    }else{
        if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
            $realip = getenv("HTTP_CLIENT_IP");
        }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
            $realip = getenv("REMOTE_ADDR");
        }else{
            $realip = $unknown;
        }
    }
    $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
    return $realip;
}

function GetIpLookup($ip = ''){
    if(empty($ip)){
        $ip = GetIp();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){ return false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    return $json;
}





//核心函数包

//********************************************

//  作者：hury

//  时间：2017-03-01

//  作用：前后端函数包 区分使用  降低耦合 便于管理

//********************************************

function load_func($filepath=null){
    if(is_string($filepath) && is_file($filepath) ){
        $success = include_once $filepath;
        return $success ? true : false;
    }
}

/**
 *
 * 配置信息默认储存在当前目录的Conf文件夹下的config.php
 */
/**
 * [C 获取文件中的配置信息 供全局使用]
 * @param [type] $name  [获取变量值 兼容大小写]
 * @param [type] $value [设置变量]
 */
function C($name=null,$value=null){
    static $_config = array();
    //直接调用 C() 时,获取全部
    if(empty($name))return $_config;

    //获取
    if(is_string($name)) {
        $name = strtoupper($name);
        if(!is_null($value)){
            $_config[$name] =$value;
        }else{
            return isset($_config[$name]) ? $_config[$name] : null;
        }
    }
    //批量设置
    if(is_array($name)) {
        $_config = array_merge($_config, array_change_key_case($name, CASE_UPPER));
        return null;
    }
    return null;

}



/**
 * 加载配置文件 支持格式转换 仅支持一级配置
 * @param string $file 配置文件名
 * @param string $debug 上线修改为false
 * @return array
 */
function load_config($file){
    $ext  = pathinfo($file,PATHINFO_EXTENSION);
    switch($ext){
        case 'php':
        return include_once $file;
        case 'ini':
        return parse_ini_file($file);
        case 'yaml':
        return yaml_parse_file($file);
        case 'xml':
        return (array)simplexml_load_file($file);
        case 'json':
        return json_decode(file_get_contents($file), true);
        default:
        throw new Exception('不支持的文件格式 : ' . $ext);
    }
}

/**
 * [auto_load 自动加载]
 * @param  [type] $fileConfig [description]
 * @return [type]             [description]
 */
function auto_load($fileConfig=null){
    //如果加载项为空 加载默认扩展名
    if(empty($fileConfig)){
        $cal = 0;
        $default = array('json','php');
        foreach ($default as $ext) {
            $file = _DIR_.'/conf/config.'.$ext;
            if(file_exists($file)){
                C(load_config($file));
                ++$cal;
            }
        }
        return $cal>0 ? 1 : NULL;
    }
    //自定加载某个文件
    if(is_string($fileConfig) && file_exists($fileConfig)){
        C(load_config($fileConfig));
    }
    return null;
}


/**
 * [autoload spl_autoload_register]
 * @param  [type] $class [description]
 * @return [type]        [description]
 */
function autoload($class){
    $files = array();
    $files[0] = _DIR_.'/library/'.$class.EXT;
    $files[1] = _DIR_.'/vendor/'.$class.EXT;
    $files[2] = _DIR_.'/../'.$class.EXT;
    $files[3] = _DIR_.'/../../web_manage/include/'.$class.EXT;
    foreach ($files as $key => $value) {
        if(file_exists($value)){
            require_once $value;
            return;
        }
    }
}

/**
 * 实例化一个没有模型文件的Model
 * @param string $name Model名称 支持指定基础模型 例如 MongoModel:User
 * @param string $tablePrefix 表前缀
 * @param mixed $connection 数据库连接信息
 * @return Think\Model
 */
function M($name=''){return HR($name);}
function HR($name='') {
    if (is_null(Config::get("HR.$name"))) {
        Config::set("HR.$name", new Model($name));
    }
    return Config::get("HR.$name");
}

function table_exists($table=''){
    $sql = sprintf("select table_name from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA='%s' and TABLE_NAME='%s' ;", config('database.database'), config('database.prefix').trim($table, '`'));
    $res = M()->query($sql);
    return $res ? true : false;
    /*$table = Config('database.prefix').$table;
    if(empty($table))return false;
    //表存在
    $tables = M()->query('SHOW TABLES FROM '.C('DB_NAME'));
    $tables = array_merge_values($tables);
    if(!in_array($table,$tables)){
        return false;
    }else{
        return true;
    }*/

}


/**
 * [array_merge_values 数组降维 : 将二维数组合并为一维]
 * @param  [type] $hay [description]
 * @return [type]      [返回值数组]
 */
function array_merge_values($hay){
    $newArr = array();
    foreach ($hay as $key => $value) {
        $newArr[] = current($value);
    }
    return $newArr;

}
/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type=0) {
    // ECHO $name;
    /*if ($type) {
        //return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function($match){return strtoupper($match[1]);}, $name));
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    } else {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }*/
    return $name;
}
/**
 * [R 自动加载类库]
 * @param string $class [类名称]
 * @param [type] $arg   [有参构造函数]
 * @return 返回类的实例
 */
function R($class='',$arg=null,$import=false){
    $file1 = LIB_PATH . $class . EXT;
    $file2 = VENDOR_PATH . $class . EXT;

    $file = is_file($file1) ? $file1 : (is_file($file2) ?  $file2 : '' );
    UNSET($file1,$file2);

    if($file){
        include_once $file;
        if(strpos(ltrim($class,'/'),'/') !== false){
            $end = explode('/',$class);
            $class = end($end); UNSET($end);
        }
        if($import)return true;//只加载不实例化

        if(is_null($arg)){
            $instance = new $class();
        }else{
            $instance = new $class($arg);
        }
        return $instance;
    }
    E(LogRecord("[ 库不存在 ] $file"));

}


function L($msg){
    return LogRecord($msg);
}
function LogRecord($log,$destination=''){
    //是否开启日志写入功能
    if(! Config::get('log.record') ) return;
    $now = date('c');

    if(empty($destination)){
        $destination = Config::get('log.path').date('y_m_d').'.log';
    }

        // 自动创建日志目录
    $log_dir = dirname($destination);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
    if(is_file($destination) && floor(Config::get('log.size')) <= filesize($destination) ){
        rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
    }
        error_log("[{$now}] ".$_SERVER['REMOTE_ADDR'].' '.$_SERVER['REQUEST_URI']."\r\n{$log}\r\n", 3,$destination);
    return $log;
}

/**
 * 抛出异常处理
 * @param string $msg 异常消息
 * @param integer $code 异常代码 默认为0
 * @throws Think\Exception
 * @return void
 */
function E($msg, $code=0) {
    echo '<pre>';
    if(Config::get('app_debug')){
        throw new Exception($msg, $code);
    }
    exit( '!系统发生错误!');
}

/**
 * 记录和统计时间（微秒）和内存使用情况
 * 使用方法:
 * <code>
 * G('begin'); // 记录开始标记位
 * // ... 区间运行代码
 * G('end'); // 记录结束标签位
 * echo G('begin','end',6); // 统计区间运行时间 精确到小数后6位
 * echo G('begin','end','m'); // 统计区间内存使用情况
 * 如果end标记位没有定义，则会自动以当前作为标记位
 * 其中统计内存使用需要 MEMORY_LIMIT_ON 常量为true才有效
 * </code>
 * @param string $start 开始标签
 * @param string $end 结束标签
 * @param integer|string $dec 小数位或者m
 * @return mixed
 */
define('MEMORY_LIMIT_ON',true);
function G($start,$end='',$dec=4) {
    static $_info       =   array();
    static $_mem        =   array();
    if(is_float($end)) { // 记录时间
        $_info[$start]  =   $end;
    }elseif(!empty($end)){ // 统计时间和内存使用
        if(!isset($_info[$end])) $_info[$end]       =  microtime(TRUE);
        if(MEMORY_LIMIT_ON && $dec=='m'){
            if(!isset($_mem[$end])) $_mem[$end]     =  memory_get_usage();
            return number_format(($_mem[$end]-$_mem[$start])/1024);
        }else{
            return number_format(($_info[$end]-$_info[$start]),$dec);
        }

    }else{ // 记录时间和内存使用
        $_info[$start]  =  microtime(TRUE);
        if(MEMORY_LIMIT_ON) $_mem[$start]           =  memory_get_usage();
    }
    return null;
}

/**
 * 获取输入参数 支持过滤和默认值
 * 使用方法:
 * <code>
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 * </code>
 * @param string $name 变量的名称 支持指定类型
 * @param mixed $default 不存在的时候默认值
 * @param mixed $filter 参数过滤方法
 * @param mixed $datas 要获取的额外数据源
 * @return mixed
 */
function I($name,$default='',$filter=null,$datas=null) {
    static $_PUT    =   null;
    if(strpos($name,'/')){ // 指定修饰符
        list($name,$type)   =   explode('/',$name,2);
    }elseif(C('VAR_AUTO_STRING')){ // 默认强制转换为字符串
        $type   =   's';
    }

    if(strpos($name,'.')) { // 指定参数来源
        list($method,$name) =   explode('.',$name,2);
    }else{ // 默认为自动判断
        $method =   'param';
    }
    switch(strtolower($method)) {
        case 'get'     :
            $input =& $_GET;
            break;
        case 'post'    :
            $input =& $_POST;
            break;
        case 'put'     :
            if(is_null($_PUT)){
                parse_str(file_get_contents('php://input'), $_PUT);
            }
            $input  =   $_PUT;
            break;
        case 'param'   :
            switch($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $input  =  $_POST;
                    break;
                case 'PUT':
                    if(is_null($_PUT)){
                        parse_str(file_get_contents('php://input'), $_PUT);
                    }
                    $input  =   $_PUT;
                    break;
                default:
                    $input  =  $_GET;
            }
            break;
        case 'path'    :
            $input  =   array();
            if(!empty($_SERVER['PATH_INFO'])){
                $depr   =   C('URL_PATHINFO_DEPR');
                $input  =   explode($depr,trim($_SERVER['PATH_INFO'],$depr));
            }
            break;
        case 'request' :
            $input =& $_REQUEST;
            break;
        case 'session' :
            $input =& $_SESSION;
            break;
        case 'cookie'  :
            $input =& $_COOKIE;
            break;
        case 'server'  :
            $input =& $_SERVER;
            break;
        case 'globals' :
            $input =& $GLOBALS;
            break;
        case 'data'    :
            $input =& $datas;
            break;
        default:
            return null;
    }
    if(isset($input[$name])) { // 取值操作
        $data       =   $input[$name];
        $filters    =   isset($filter) ? $filter : Config::get('default_filter');
        if($filters) {
            if(is_string($filters)){
                if(0 === strpos($filters,'/')){
                    if(1 !== preg_match($filters,(string)$data)){
                        // 支持正则验证
                        return   isset($default) ? $default : null;
                    }
                }else{
                    $filters    =   explode(',',$filters);
                }
            }elseif(is_int($filters)){
                $filters    =   array($filters);
            }

            if(is_array($filters)){
                foreach($filters as $filter){
                    if(function_exists($filter)) {
                        $data   =   is_array($data) ? array_map_recursive($filter,$data) : $filter($data); // 参数过滤
                    }else{
                        $data   =   filter_var($data,is_int($filter) ? $filter : filter_id($filter));
                        if(false === $data) {
                            return   isset($default) ? $default : null;
                        }
                    }
                }
            }
        }
        if(!empty($type)) {
            switch(strtolower($type)) {
                case 'a':   // 数组
                    $data   =   (array)$data;
                    break;
                case 'd':   // 数字
                    $data   =   (int)$data;
                    break;
                case 'f':   // 浮点
                    $data   =   (float)$data;
                    break;
                case 'b':   // 布尔
                    $data   =   (boolean)$data;
                    break;
                case 's':   // 字符串
                default:
                    $data   =   (string)$data;
            }
        }
    }else{ // 变量默认值
        $data       =    isset($default)?$default:null;
    }
    is_array($data) && array_walk_recursive($data,'sql_filter');
    return $data;
}
function array_map_recursive($filter, $data) {
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val)
         ? array_map_recursive($filter, $val)
         : call_user_func($filter, $val);
    }
    return $result;
 }


function sql_filter(&$value){
    // TODO 其他安全过滤

    // 过滤查询特殊字符
    if(preg_match('/^(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|IN)$/i',$value)){
        $value .= ' ';
    }
}

/**
 * [hr_filter 参数过滤]
 * @param  [type] &$value [过滤的值]
 * @param  [type] $fp     [是否过滤五种特殊字符 * # \/ ]
 * @return [type]         [无返回 引用]
 */
function sql_filter_strict(&$value,$fp=false){
    // TODO 其他安全过滤
    if($fp){
        // ' : &#39; " : &#34; * : &#42; # : &#35; \ : &#92;
        $research = array('&#39;','&#34;','&#42;','&#35;','&#92;','\'','"','#','*','\\');
        $value = str_replace($research,'',$value);
    }
    // 过滤查询特殊字符
    $value = preg_replace('/(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|IN)/i','',$value);
}
