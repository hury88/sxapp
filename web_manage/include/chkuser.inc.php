<?php
@session_start();
session_cache_expire(30);
if(!isset($_SESSION['Admin_UserName']) || $_SESSION['is_admin']=="")
{
	@session_destroy();
	echo"<script language='javascript'>top.document.location.href='../web_manage/index.php';</script>";
	exit();
}

//集中处理页面
$frameTitle='';
	if (defined('TABLE_NEWS')) {//
		$id    =   I('get.id', 0,'intval');
		$pid   =   I('get.pid',0,'intval');
		$ty    =   I('get.ty', 0,'intval');
		$tty   =   I('get.tty',0,'intval');
		$classname='<a href="javascript:void()">'.v_news_cats($pid,'catname').'</a> <span>></span> <a href="javascript:void()">'.v_news_cats($ty,'catname').'</a>';
		$zid=$ty;
		if($tty){
			$zid=$tty;
			$classname .= '<span>></span> <a href="javascript:void()">'.v_news_cats($tty,'catname').'</a>';
		}
		if(isset($_GET['showtype'])){//主动传值优先级最大
			$showtype = (int)$_GET['showtype'];
		}else{
			$showtype=v_news_cats($zid,"showtype");
		}
		$frameTitle='位置： <a href="mains.php">首页</a> > '.$classname;
		// $frameTitle='位置： ';
	}
