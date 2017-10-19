<?php
// require './include/common.inc.php';
// require WEB_ROOT.'./include/chkuser.inc.php';
define('IN_COPY',1);
require '../include/Common/functions.php';

/**
 * @
 * @Description:
 * @Copyright (C) 2011 helloweba.com,All Rights Reserved.
 * -----------------------------------------------------------------------------
 * @author: Liurenfei (lrfbeyond@163.com)
 * @Create: 2012-5-1
 * @Modify:
*/

$action = I('get.action','');
if ($action == 'import') { //导入CSV
	$filePath = $_FILES['file']['tmp_name'];
	$fileName = $_FILES['file']['name'];
	$fileType = pathinfo($fileName,PATHINFO_EXTENSION);
	if (empty ($filePath)) {
		redirect($_SERVER['HTTP_REFERER'],2,'请选择要导入的CSV文件！');
		exit;
	}elseif($fileType!='csv'){
		redirect($_SERVER['HTTP_REFERER'],2,'请导入CSV格式的文件！');
		exit;
	}
	// $handle = file_get_contents($filePath);
	// ECHO $handle;
	// $handle = file_get_contents($filePath);
	$handle = fopen($filePath,'r');
	$result = input_csv($handle); //解析csv
	array_walk_recursive($result, 'gb2utf');
	// dump($result);exit;
	$len_result = count($result);
	if($len_result==0){
		echo '没有任何数据！';
		exit;
	}
	array_shift($result);
	// dump($result);exit;
	foreach ($result as $key => $row) {
		$fields = array();
		$fields['sku'] = $sku   = $row[0];
		$fields['cas'] 			= $row[1];
		$fields['title']  = $row[2];
		$fields['ftitle']  = $row[3];
		$fields['unit'] 		= $row[4];
		$cate 		= explode('->',$row[5]);//分类
		$fields['suppliers'] 	= $row[6];
		$fields['price'] 		= $row[7];
		$fields['price2'] 		= $row[8];
		$fields['content'] 		= htmlspecialchars($row[9]);
		$fields['isstate'] 		= 1;
		$fields['sendtime'] 	= time();
		$cate1 = $cate[0];//一级分类
		$cate2 = $cate[1];//二级分类
		$pid = M('news_cats')->where("`catname`='$cate1'")->getField('id');
		if ($pid) {//存在一级
			$ty = M('news_cats')->where("`pid`=$pid AND `catname`='$cate2'")->getField('id');//找二级
			if ($ty) {//二级存在
				$fields['pid'] = $pid;$fields['ty'] = $ty;
				$skuId = M('products')->where("`sku`='$sku'")->getField('id');
				if ($skuId) {//数据已存在
					$fields['id'] = $skuId;
					M('products')->update($fields);
					$word = '第<b style="color:red">'.($key+1).'</b>行数据已存在,执行更新操作'."-------------------------------------------[$sku]";
				}else{//不存在
					$a = M('products')->insert($fields);
					if ($a) {
						$word = $cate1.'-'.$cate2.'--+<'.$a.'>插入成功'."[$sku]";
					}else{
						$word = $cate1.'-'.$cate2.'--+>>>>>>>>>>>>>>>>>>>>>>>>>>>>>插入失败'."-------------------------------------------[$sku]";
					}
				}
			}else{//二级不存在
				$word = $cate1.'下不存在二级分类-<b>'.$cate2.'</b>请先创建'."-------------------------------------------[$sku]";
			}
		}else{
			$word = '第'.($key+1).'行数据所属一级分类--<b>'.$cate1.'</b>--不存在请检查格式是否错误'."-------------------------------------------[$sku]";
		}
		ECHO $word.'<br>';ob_flush();flush();
	}
	ECHO '导入结束,为方便查看导入状况,不做自动跳转,请自行跳转<button onclick="history.back()">点击跳转</button>';
	fclose($handle); //关闭指针
} elseif ($action=='export') { //导出CSV
	$pid   =   I('get.pid',0,'intval');$cate1 = _gfv($pid);utf2gb($cate1,0);
	$ty    =   I('get.ty', 0,'intval');$cate2 = _gfv($ty);utf2gb($cate2,0);

	$headlist = array('bn:商品货号','CASNO','col:商品名称','英文名称','col:单位','col:分类','col:品牌','col:成本价','col:销售价','col:详细介绍');
    $map = array('pid'=>$pid,'ty'=>$ty);
    $result = M('products')->field('sku,cas,title,ftitle,unit,suppliers,price,price2,content')->where($map)->select();
    $cate = $cate1.'->'.$cate2;
	array_walk_recursive($result, 'utf2gb');
	array_walk_recursive($headlist, 'utf2gb');
    $filename = $cate1.'_'.$cate2;
    $filename = str_replace(array('/','\\','>','<','#','*','|','?',':','"'),'-',$filename);
    csv_export($result,$headlist,$cate,$filename);
}
function input_csv($handle) {
	$out = array();
	$n = 0;
	while ($data = fgetcsv($handle, 10000)) {
		$num = count($data);
		for ($i = 0; $i < $num; $i++) {
			$temp='';
			$temp = trim($data[$i]);
			$out[$n][$i] = str_replace('"',"\\\"",$temp);
		}
		$n++;
	}
	return $out;
}

function export_csv($filename,$data) {
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo trim($data);
}

 /**
 * 导出excel(csv)
 * @data 导出数据
 * @headlist 第一行,列名
 * @fileName 输出Excel文件名
 */
function csv_export($data = array(), $headlist = array(), $cate, $fileName) {

    header("Content-type:text/csv");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
    header('Cache-Control: max-age=0');
    //打开PHP文件句柄,php://output 表示直接输出到浏览器
    $fp = fopen('php://output', 'a');

    //输出Excel列名信息
    //将数据通过fputcsv写到文件句柄
    fputcsv($fp, $headlist);

    //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
    $limit = 100000;

    //逐行取出数据，不浪费内存
    // $count = count($data);
    foreach ($data as $key => $row) {
        //刷新一下输出buffer，防止由于数据过多造成问题
        // if ($limit == $num) { ob_flush(); flush(); $num = 0; }
        $content = htmlspecialchars_decode($row['content']);
        $val = array();
        $val[0] = $row['sku'];
        $val[1] = $row['cas'];
        $val[2] = $row['title'];
        $val[3] = $row['ftitle'];
        $val[4] = $row['unit'];
        $val[5] = $cate;
        $val[6] = $row['suppliers'];
        $val[7] = $row['price'];
        $val[8] = $row['price2'];
        $val[9] = strtr($content,',','，');
        fputcsv($fp, $val);
    }
  }

function gb2utf(&$val,$key){
    $val = iconv('gb2312','utf-8',$val);
}
function utf2gb(&$val,$key){
    $val = iconv('utf-8','gb2312',$val);
}
?>
