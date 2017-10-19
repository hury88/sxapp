<?php
require 'common.inc.php';
require 'chkuser.inc.php';

//所有的提交集中处理
$a = I('get.a','');
$t = I('t','');//表名
$s = I('s',0,'intval');
$id= I('id', 0,'intval');
if(empty($t))$t='news';

$pid   =   I('pid',0,'intval');
$ty    =   I('ty', 0,'intval');
$tty   =   I('tty',0,'intval');

if(IS_GET){

	//改变状态
		$action = array(

			'isstate' => config('webarr.isstate'),
			'isgood'  => config('webarr.isgood'),
			'istop'   => config('webarr.istop'),
			'isdownload' => config('webarr.isdownload'),
			'isindex'   => config('webarr.istop'),

			'is_hot'   => config('webarr.is_hot'),
			'is_recommend'   => config('webarr.is_recommend'),
			'is_new'   => config('webarr.is_new'),
		);
		if(!empty($s)){//各种状态修改
			$remind = $action[$a];
			$a = $remind[2];
			if (empty($id)){
				echo 'no';
			}
			$set= M($t)->where("id=$id")->setField(array($a=>array('exp','NOT('.$a.')')));
			if ($set) {
				$val = M($t)->where("id=$id") ->getField($a);
				echo $remind[$val];
			}else{
				echo 'no';
			}
		}
}
$map=array();
if(IS_POST){
	if(isset($_POST['ids'])) {
		// $checkid=$_POST['checkid'];
		$ids = $_POST['ids'];
		if(empty($ids))$ids=0;
		// $map['id']  = array('in',$ids);
		switch ($t) {
			case 'news_cats':
				$delStatus= deleteNewsCats($ids);
				break;
			case 'news':
				$delStatus= deleteNews($ids);
				break;
			case 'order':
				$delStatus= deleteOrders($ids);
				break;
			case 'usr':
				$delStatus= deleteUsers($ids);
			case 'usr_need':
				$delStatus= deleteUsrNeed($ids);
				break;
			case 'property':
				$delStatus= deleteProperty($ids);
				break;
			case 'pic':
				$delStatus= deletePics($ids);
				break;
			default:
				$delStatus= M($t)->delete($ids);
				$delStatus && AddLog("删除{$t}内容",$_SESSION['Admin_UserName']);
				break;
		}
		// $data = HR($t)->where($map)->select();

		 if ( $delStatus ) {
			ajaxReturn(1,'删除成功!');
		 }else{
			ajaxReturn(-1,'删除失败!');
		 }
	} elseif($a == 'dropupload') {
		$id = I('get.id',0,'intval');
		$cid = I('get.cid',0,'intval');
		$fields = array(
			'ti'=>$id,
			'cid'=>$cid,
			'title'=>'',
			'disorder'=>0,
			'isstate'=>1,
		);
		uppro('img1',$fields,'ajax');
		if (M('pic')->insert($fields)) {
			$img = src($fields['img1']);
			ajaxReturn(1,$img);
		}else{
			ajaxReturn(-1,'图片插入失败');
		}
	} else {//添加数据或者更新
		#出入表名
		$WithData = new WithData($t, $id);

		$ajaxReturn = $WithData->submit();

		ajaxReturn($ajaxReturn[0], $ajaxReturn[1]);


	}
}


function deleteNews($ids=0,$map=array()){//删除新闻及与他的子级
	$map['id']  = array('in',$ids);
	$path = trim(ROOT_PATH, DS) . Config::get('pic.upload');
	$data = M('news')->where($map)->select();
	M()->startTrans();
	if(M('news')->delete($ids)):
		foreach ($data as $key => $row) {
			AddLog("删除news内容:".$row['title'],$_SESSION['Admin_UserName']);
			isset($row['img1']) ? @unlink($path.$row['img1']) : '';
			isset($row['img2']) ? @unlink($path.$row['img2']) : '';
			isset($row['img3']) ? @unlink($path.$row['img3']) : '';
			isset($row['img4']) ? @unlink($path.$row['img4']) : '';
			isset($row['img5']) ? @unlink($path.$row['img5']) : '';
			isset($row['img6']) ? @unlink($path.$row['img6']) : '';
			isset($row['file']) ? @unlink($path.$row['file']) : '';
			$ids2 = M('pic')->where(array('ti'=>array('in',$ids)))->getField('id',true);
			if($ids2){
				// $ids2 = array_merge_values($ids2);
				$ids2 = implode(',',$ids2);
				deletePics($ids2);
			}
		/*$map2['tty']  = array('in',$ids);
		if($data2 = M('news')->where($map2)->select()){
			foreach ($data2 as $key2 => $row2) {
				M('news')->delete($row2['id']);
				isset($row2['img1']) ? @unlink($path.$row2['img1']) : '';
				isset($row2['img2']) ? @unlink($path.$row2['img2']) : '';
				isset($row2['img3']) ? @unlink($path.$row2['img3']) : '';
				isset($row2['img4']) ? @unlink($path.$row2['img4']) : '';
				isset($row2['img5']) ? @unlink($path.$row2['img5']) : '';
				isset($row2['img6']) ? @unlink($path.$row2['img6']) : '';
				isset($row2['file']) ? @unlink($path.$row2['file']) : '';
			}
		}*/
	}
	M()->commit();
	return true;
	else:
		M()->rollback();
		return false;
	endif;

}


function deleteProperty($ids=0,$map=array()){//删除新闻及与他的子级
	$map['id']  = array('in',$ids);
	$path = trim(ROOT_PATH, DS) . Config::get('pic.upload');
	$data = M('property')->where($map)->select();
	M()->startTrans();
	if(M('property')->delete($ids)):
		foreach ($data as $key => $row) {
			AddLog("删除房源内容:".$row['title'],$_SESSION['Admin_UserName']);
			isset($row['img1']) ? @unlink($path.$row['img1']) : '';
			isset($row['doc1']) ? @unlink($path.$row['doc1']) : '';
			isset($row['doc2']) ? @unlink($path.$row['doc2']) : '';
			isset($row['doc3']) ? @unlink($path.$row['doc3']) : '';
			isset($row['doc4']) ? @unlink($path.$row['doc4']) : '';
			$ids2 = M('pic')->where(array('ti'=>array('in',$ids)))->getField('id',true);
			if($ids2){
				// $ids2 = array_merge_values($ids2);
				$ids2 = implode(',',$ids2);
				deletePics($ids2);
			}
	}
	M()->commit();
	return true;
	else:
		M()->rollback();
		return false;
	endif;

}

function deleteNewsCats($ids=0,$map=array()){//删除新闻及与他的子级
	$tree = new Tree(M('news_cats')->select());
	$pSet = $tree->getSon($ids);
	foreach ($pSet as $row) {
		$id = $row['id'];
		M('news_cats')->delete($id);
		$newsIds = M('news')->where("`pid`=$id OR `ty`=$id OR `tty`=$id")->getField('id',true);
		if ($newsIds) {
			$newsIds = implode(',',$newsIds);
			deleteNews($newsIds);
		}
	}
	return true;
}

function deleteOrders($ids,$map=array()){//删除订单及关联的log
	$map['id']  = array('in',$ids);
	$data = M('news')->where($map)->select();
	M()->startTrans();
	if(M('order')->delete($ids))://删除订单
		$map2['oid']  = array('in',$ids);
		if($data2 = M('log')->where($map2)->select()){
			foreach ($data2 as $key2 => $row2) {
				HR('log')->delete($row2['id']);//删除日志
			}
		}
		M()->commit();
		return true;
	else:
		M()->rollback();
		return false;
	endif;

}


function deleteUsers($ids,$map=array()){//删除用户  删除对应订单
	$map['id']  = array('in',$ids);
	$data = HR('user')->where($map)->select();
	M()->startTrans();
	if(M('user')->delete($ids))://删除用户
		$map2['uid']  = array('in',$ids);
		if($data2 = HR('order')->where($map2)->select()){
			foreach ($data2 as $key2 => $row2) {
				deleteOrders($row2['id']);//删除订单
			}
		}
		M()->commit();
		return true;
	else:
		M()->rollback();
		return false;
	endif;

}

function deleteUsrNeed($ids,$map=array()){//删除需求
	$map['id']  = array('in',$ids);
	$path = trim(ROOT_PATH, DS) . Config::get('pic.needImage');
	$data = M('usr_need')->where($map)->select();
	M()->startTrans();
	if(M('usr_need')->delete($ids)):
		foreach ($data as $row) {
			isset($row['img']) ? @unlink($path.$row['img']) : '';
		}
		M()->commit();
		return true;
	else:
		M()->rollback();
		return false;
	endif;

}

function deletePics($ids){//删除关联图片
	$map['id']  = array('in',$ids);
	$path = trim(ROOT_PATH, DS) . Config::get('pic.upload');
	$data = M('pic')->where($map)->select();
	M()->startTrans();
	if(M('pic')->delete($ids)):
		foreach ($data as $row) {
			isset($row['img1']) ? @unlink($path.$row['img1']) : '';
		}
		M()->commit();
		return true;
	else:
		M()->rollback();
		return false;
	endif;

}



 ?>