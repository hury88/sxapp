<?php
header('Content-Type:text/html;charset=utf-8');
//定义PHP环境
error_reporting(E_ALL);

//设置开始的时间
//$mtime[0] 为微秒 $mtime[1]为UNIX时间戳
$mtime = explode(' ', microtime());
$sys_starttime = $mtime[1] + $mtime[0];

//销毁一些不用的服务器变量
unset($_REQUEST, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);

//WEB 加载WEB包
define('WEB', true);

//定义WEB的路径,,,,,磁盘绝对路径!
define('WEB_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);		//定义WEB的路径,,,,,磁盘绝对路径!
require  WEB_ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'run.php';/*加载hr函数库*/

if (Config::get('app_debug')) {
	error_reporting(E_ALL);
}

//如果浏览者是一个robot
define('ISROBOT', getrobot());
if(defined('NOROBOT') && ISROBOT) {
	exit(header("HTTP/1.1 403 Forbidden"));
}


isset($_REQUEST['GLOBALS']) && exit('Access Error');

//获取客户端IP
//Request::instance()
$PHP_IP = Request::instance()->ip();
//获得当前时间
$PHP_TIME = time();
$PHP_DATE = date('Y-m-d H:i:s');


//获得自己脚本的文件名  如: /test.php
$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
//获得查询字符串 也就是 xxx.php?4982394  问号后面的内容
$PHP_QUERYSTRING = $_SERVER['QUERY_STRING'];
//获得服务器的域名  不包括 http://
$PHP_DOMAIN = $_SERVER['SERVER_NAME'];
//链接到当前页面的前一页面的 URL 地址。不是所有的用户代理（浏览器）都会设置这个变量，而且有的还可以手工修改 HTTP_REFERER。因此，这个变量不总是正确真实的。
$PHP_REFERER = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
//获得http端口
$PHP_SCHEME = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$PHP_PORT = $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
//得到完整的PHPCMS的URL地址
// $PHP_SITEURL = $PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.WEB_PATH;
//得到当前网页的URL地址
$PHP_URL = $PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.$PHP_SELF.($PHP_QUERYSTRING ? '?'.$PHP_QUERYSTRING : '');
$PHP_FILE = $PHP_SELF.($PHP_QUERYSTRING ? '?'.$PHP_QUERYSTRING : '');

// $RrPHP_FILE=$_SERVER['HTTP_REFERER'];

@session_start();

//平衡负载*
if(!empty($loadctrl) && substr(PHP_OS, 0, 3) != 'WIN') {
	if($fp = @fopen('/proc/loadavg', 'r')) {
		list($loadaverage) = explode(' ', fread($fp, 6));
		fclose($fp);
		if($loadaverage > $loadctrl) {
			header("HTTP/1.0 503 Service Unavailable");
			include WEB_ROOT.'include/serverbusy.htm';
			exit();
		}
	}
}

//Debug::dump(M());
//打开公用信息
if($bd=M('config')->find()){
	array_walk($bd, 'array_walk_decode');
	extract($bd,EXTR_PREFIX_ALL,'system');
	$system_logo1 = src($system_logo1);
	$system_logo2 = src($system_logo2);
	$system_img1 = src($system_img1);
	$system_file = src($system_file);
}
$system_ThisUrl = $_SERVER['REQUEST_URI'];
unset($sql,$result,$bd);
#安全防护
require_once("360_safe3.php");
#加载映射关系
if (is_file(APP_PATH . 'home' . DS . 'map' .EXT)) {
  Config::set('map',include(APP_PATH . 'home' . DS . 'map' .EXT));
  Config::set('map_flip', array_flip(Config::get('map')));
}
