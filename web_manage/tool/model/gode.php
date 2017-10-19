<?php
require '../../../core/run.php';

define('TPLS', dirname(__DIR__) .DS. 'tpls' .DS );
define('CODE_TPLS', TPLS . 'code' .DS );
$ty = isset($_POST['ClassID'][0]) ? $_POST['ClassID'][0] : 0;
$tpl = I('post.tpl', '', 'trim');
$function = I('post.function', '', 'trim');$function or $function = 'default';

$Row = M('news_cats')->find($ty);
$pid = $Row['pid'];


$data = load_config('../config/gode.json');
$html = new Html;

isset($data[$tpl]) or die('没找到模板');

$tpl_array = $data[$tpl];
$tpl_name = $tpl_array[0];
$tpl_func = $tpl_array[1];

$tpl_path = CODE_TPLS . $tpl_name .'.tpl';
$tpl_path_gbk = iconv('utf-8', 'gbk', $tpl_path);
$html->open($tpl_path_gbk);


eval("echo $tpl_func;");
// echo strReplace(['_PID_'=>$pid, '_TY_'=>$ty, '_FUNCTION_'=>$function], $html->strings);


// 生成HOME文件夹
function strReplace($map, $string)
{
	$keys = array_keys($map);
	$vals = array_values($map);

	return str_replace($keys, $vals, $string);

}

