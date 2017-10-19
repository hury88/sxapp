<?php
require_once 'app/common.incs.php';
header("X-Powered-By:http://www.semfw.cn");
if (isset($analogUri)) {// 静态页使用
	$requestUri = $analogUri;
} else {
	$requestUri = Request::instance()->url();
}
// 路由解析 model或者controller
list($controller, $method) = Config::route($requestUri);
define('HOME', APP_PATH . 'home' .DS);
define('DOCTYPE', HOME . 'doctype' .EXT);
define('HEAD', HOME . 'head' .EXT);
define('FOOT', HOME . 'foot' .EXT);
define('__PUBLIC__', HOME . 'public' .DS);
define('IS_INDEX',$controller == 'index');
define('IS_LIST',$method == 'index');
// 引入业务处理代码
include HOME . 'processing.php';
if (class_exists(ucfirst($controller)) && method_exists(ucfirst($controller), $method)) {
	$octrl = new $controller();
	call_user_func_array([$octrl,$method], [$GLOBALS]);
} else {
	die(config('r404'));
	// header("location:" . U('index'));
}
