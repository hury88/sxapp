<?php
header('Content-Type:text/html;charset=utf-8');
error_reporting(E_ALL);

define('ADMIN',TRUE);

//设置开始的时间

//$mtime[0] 为微秒 $mtime[1]为UNIX时间戳

$mtime = explode(' ', microtime());

$sys_starttime = $mtime[1] + $mtime[0];



//销毁一些不用的服务器变量

unset($_REQUEST, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);


define('WEB_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);		//定义WEB的路径,,,,,磁盘绝对路径!
require  WEB_ROOT . '..' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'run.php';/*加载hr函数库*/
//引入 配置文件 语言文件 全局函数库!

$PHP_IP = Request::instance()->ip();
$PHP_TIME = time();


//如果浏览者是一个robot

define('ISROBOT', getrobot());

if(defined('NOROBOT') && ISROBOT) {

	exit(header("HTTP/1.1 403 Forbidden"));

}


isset($_REQUEST['GLOBALS']) && exit('Access Error');


//检查gzip是不是打开了，打开就用ob_gzhandler，没有就用ob_start
if(extension_loaded('zlib')) {
	// ob_start('ob_gzhandler');

} else {

	$gzipcompress = 0;

	ob_start();

}

@session_start();



//平衡负载*

if(!empty($loadctrl) && substr(PHP_OS, 0, 3) != 'WIN') {

	if($fp = @fopen('/proc/loadavg', 'r')) {

		list($loadaverage) = explode(' ', fread($fp, 6));

		fclose($fp);

		if($loadaverage > $loadctrl) {

			header("HTTP/1.0 503 Service Unavailable");

			include WEB_ROOT.'./include/serverbusy.htm';

			exit();

		}

	}

}

//设置一个 $web_auth_key，md5加密

$web_auth_key = md5($_SERVER['HTTP_USER_AGENT']);
//打开数据连接

//设置后台相关参数
if($bd=M('config')->find(1)){
	extract($bd,EXTR_PREFIX_ALL,'system');
	$System_Filetype	=	$system_filetype;
	$System_Filesize	=	$system_filesize;
	$System_Pictype	    =	$system_pictype;
	$System_Picsize	    =	$system_picsize;
}

$webarr = Config::get('webarr');
//定义后台每页显示条目数量
?>