<?php

//核心函数包

//********************************************

//  作者：hury

//  时间：2017-03-01

//  作用：前后端函数包 区分使用  降低耦合 便于管理

//********************************************
//加载文件
if(!defined('IN_COPY')) {
    exit('Access Denied');
}


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
    static $_model  = array();
    if(strpos($name,':')) {
        list($class,$name)    =  explode(':',$name);
    }else{
        $class      =   'Model';
    }
    C('HR',new Model);
    return C('HR');
}

/*function HR($table=''){
    $table = C('DB_PREFIX').$table;
    if(empty($table))return C('DB');
    //表存在
    $tables = Q('SHOW TABLES FROM '.C('DB_NAME'));
    $tables = array_merge_values($tables);
    if(!in_array($table,$tables)){
        E(LogRecord("unkown table_name [ `$table` ] in [ ".C('DB_NAME')." ]"));
    }else{
        // 加载 HR类(连贯操作)
        C('HR',R('HR',$table));
        return C('HR');
    }

}*/

function table_exists($table=''){
    $table = C('DB_PREFIX').$table;
    if(empty($table))return false;
    //表存在
    $tables = M()->query('SHOW TABLES FROM '.C('DB_NAME'));
    $tables = array_merge_values($tables);
    if(!in_array($table,$tables)){
        return false;
    }else{
        return true;
    }

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
    $file1 = _DIR_.'/Library/'.$class.'.class.php';
    $file2 = _DIR_.'/Vender/'.$class.'.class.php';

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
    if( !C('LOG_RECORD') ) return;
    $now = date('c');

    if(empty($destination)){
        $destination = C('ROOT_PATH').C('LOG_PATH').date('y_m_d').'.log';
    }

        // 自动创建日志目录
    $log_dir = dirname($destination);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
    if(is_file($destination) && floor(C('LOG_FILE_SIZE')) <= filesize($destination) ){
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
    if(C('DEBUG')){
        exit( '[错误] '.$msg);
    }
    throw new Exception($msg, $code);
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
        $filters    =   isset($filter)?$filter:C('DEFAULT_FILTER');
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
        if(!empty($type)){
            switch(strtolower($type)){
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



?>