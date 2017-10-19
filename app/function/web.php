<?php
//这里放前端的


/**
 * [uppro 上传文件及图片]
 * @return [type] [description]
 */
function uppro($iptname,$path,$originname='',$savename='',$active=Image::IMAGE_THUMB_SCALE)
{
    $realpath = trim(ROOT_PATH, DS) . $path;
    // $delimg=isset($_POST[$name]) ? $_POST[$name] : '';
    if(!isset($_FILES[$iptname]))return 0;
    $img_name = $_FILES[$iptname]['name'];
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $savename or $savename = date("YmdHis").mt_rand(10,99);
    $savename = "$savename.$ext";
    if($img_name){
        if ($originname && file_exists($realpath.$originname)) @unlink($realpath.$originname);
        uploadimg($iptname,$realpath,$savename,$active);
        return $savename;
    }
    return false;
}


//图片上传
function uploadimg($obj,$path,$name,$active){
    global $system_pictype,$system_picsize;
    $picaExt = explode('|',$system_pictype);                          //图片文件
    $uppic=$_FILES[$obj]['name'];                                   //文件名称
    $thumbs_type=strtolower(substr($uppic,strrpos($uppic,".")+1));  //上传类型
    $thumbs_file=$_FILES[$obj]['tmp_name'];                         //临时文件
    $thumbs_size=$_FILES[$obj]['size'];                             //文件大小
    $imageinfo = getimagesize($thumbs_file);


    $upfile=$path.$name;
    if(in_array($thumbs_type,$picaExt)&&$thumbs_size>intval($system_picsize)*1024){
        returnJson(-100,"图片上传大小超过上限:".ceil($system_picsize/1024)."M！");
    }

    if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/bmp') {
        returnJson(-100,"非法图像文件！");
    }

    if(!in_array($thumbs_type,$picaExt)){
        returnJson(-100,"上传图片格式不对，请上传".$system_pictype."格式的图片！");
    }
    if (!is_writable($path)){
        //修改文件夹权限
        $oldumask = umask(0);
        mkdir($path,0777);
        umask($oldumask);
        returnJson(-100,"请确保文件夹的存在或文件夹有写入权限");
    }

    $imgsize = config('pic.imgsize');
    if($imgsize && strpos($imgsize, '*')) {
        list($w, $h) = explode('*', $imgsize, 2);
        $image = new Image();
        $result = $image->open($thumbs_file)->thumb($w, $h, $active)->save($upfile);
    } else {
        $result = copy($thumbs_file,$upfile);
    }

    if(!$result){
        returnJson(-100,"上传失败!");
    }
}


/*//生成地址栏
function U($route, $data = [])
{
	$ustr = '';
	foreach ($data as $key => $value) {
		if(empty($key) || empty($value)) continue;
		$ustr .= "/$key/$value";
	}
	return "/$route$ustr";
	// return "/index.php/$route$ustr";
}*/

function U($route, $data = [])
{
	return defined('IS_STATIC') && IS_STATIC ? static_U($route, $data) : dynamic_U($route, $data);
}

########专门生成静态链接
function static_U($route, $data = [])
{
	$ustr = '';
	if (array_key_exists('id', $data)) {
		$id = $data['id'];
		list($route) = explode('/', $route, 2);
		if (is_numeric($route)) {
			$route = config('map_flip')[$route];
		}
		return "/$route/$id.html";
	} else {

		if (strpos($route, '/')) { //判断是否加 /
			list($route) = explode('/', $route, 2);
			if (! is_numeric($route)) {
				$route = config('map')[$route];
			}
		} else {
			if (! is_numeric($route)) {
				$route = config('map')[$route];
			}
		}
		if (array_key_exists('ty', $data)) {
			$ty = $data['ty'];
		} else {
			$ty = getNextId($route);
		}

		if (array_key_exists('page', $data)) {
			if ($data['page'] == 1) {
				$file = 'index';
			} else {
				$file = 'index_'.$data['page'];

			}
		} else {
			$file = 'index';
		}
		$route = config('map_flip')[$route];
		return "/$route/$ty/$file.html";
	}
}
########专门生成动态链接
function dynamic_U($route, $data = [])
{
	if (! strpos($route, '/')) {
		$route .= '/index';
	}
	$ustr = '';
	foreach ($data as $key => $value) {
		if(empty($key) || empty($value)) continue;
		$ustr .= "/$key/$value";
	}
	return "/$route$ustr";
}

/**
 * [pagenation 分页函数]
 * @param  [type] $config [配置]
 * @return [用法] [list($data, $pagestr, $totalRows) = pagenation($pageConfig);]
 */
function pagenation($config, $func = 'show_front_mvc_pc')
{
	$pageConfig = array(
        'where' => '',//条件
        'order' => Config::get('other.order'),//排序
        'psize' => '6',//条数
        'table' => 'news',//表
        'field' => '*',//表
        'style' => 'href',
    );
    $pageConfig = array_merge($pageConfig, $config);
    return Page::paging($pageConfig, $func);
    // return array($data,$pagestr,$totalRows);
}

//数组分页
function array_pagenation($data,$pagesize=10){

    $page = I('get.page',1,'intval');
    if($page==0)$page=1;
    $count = count($data);
    @C('PAGE_ITEMS',$count);
    $pagestr=mypage($count,$page,$pagesize);
    $chunk = array_chunk($data,$pagesize);
    $data = $chunk[($page-1)];
    return array($data,$pagestr);
}

//解析地址
function parse_U($url, &$get)
{
	$controller = $method = 'index';
	$_GET = [];
	// 1
	$url = preg_replace('/^\/index.php[\/]?/', '', $url);
	$url = trim($url,'/');
	$explode = explode('/',$url);
	$countExplode = count($explode);
	if ( $countExplode ==1 ) {
		$explode[0] && $controller = $explode[0];
	} elseif( $countExplode >= 2 ) {
		$controller = array_shift($explode);
		$method = array_shift($explode);
		if( count($explode) % 2 <> 0 ) {
			array_pop($explode);
		}
		$explode = array_chunk($explode,2);
		foreach ($explode as $value) {
			// print_r($explode);
			$_GET[$value[0]] = $value[1];
		}
	}
	// $method 进一步处理
	$explode_method = explode('?', $method, 2);
	if (count($explode_method) == 2) {
		$method = $explode_method[0] ? : 'index';
		parse_str($explode_method[1], $_GET);
	}
	return [$controller,$method];
}

	function check_verify($code, $id = '')
	{
		$verify = new Verify();
		return $verify->check($code, $id);
	}

	//id 格式：获取当前分类的第一子分类id  不可删 header调用
	function getNextId($pid,$table="news_cats")
	{

		if($bd=HR($table)->field('id')->where(array('isstate'=>1,'pid'=>$pid))->order('disorder desc,id asc')->find()){
			$id = $bd['id'];
			unset($bd,$pid,$table);
			return $id;
		}else{
			return 0;
		}
	}


	//获取上一篇下一篇
	function getNext($id,$ty=0)
	{
		$where = array(
			'id'=>array('lt',$id), //id>{$id}
			'isstate'=> 1, //审核
			'ty'=> $ty
			);
		return M('news')->where($where)->order('id desc')->find();
	}

	function getPrev($id,$ty)
	{
		$where = array(
			'id'=>array('gt',$id), //id>{$id}
			'isstate'=> 1, //审核
			'ty'=> $ty
			);
		return M('news')->where($where)->order('id desc')->find();
	}


	//获取面包屑数组
	function getBread($id,$table='news_cats')
	{
		$data = M($table)->select();
		$tree = R('Tree',$data);
		$cate = $tree->getParent($id);
		return $cate;
	}
	//返回错误信息并返回上一页面
	function ErrorHtml($Msg)
	{
		global $system_sitename;
		echo "
		<!DOCTYPE html PUBLIC -//W3C//DTD HTML 4.01 Transitional//EN>
		<html>
		<head>
		<meta http-equiv=Content-Type content=text/html; charset=utf-8>
		<title>".$system_sitename."</title>
		<style type=text/css>
		#redirect {MARGIN: 50px 25% 12px 25%}
		#h2 {font-size:12px;color:#fff;padding:4px 0px 2px 8px}
		#txt {font-size:12px;padding:10px}
		#txt a{color:#0066b9;text-decoration:underline}
		#txt a:hover {color:#b42000;text-decoration:underline}
		#input {font-size:12px}
		</style>
		</head>
		<body>
		<table cellpadding=0 cellspacing=1 bgcolor=#0066B9 width='100%' align=center id=redirect>
		<tr>
		<td id=h2>信息提示</td>
		</tr>
		<tr>
		<td bgcolor=#EFEFEF id=txt height=50>{$Msg}</td>
		</tr>
		</table>
		</body>
		</html>";
	}
