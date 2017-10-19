<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$action    =   I('get.action');
$table = 'news_cats';
$showname = 'news_cat';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>栏目管理</title>
	<?php include('js/head'); ?>
</head>

<body>
	<div class="content clr">
    	<div class="weizhi">
            <p>位置：
                <a href="mains.php">首页</a>
                <span>></span>
                <a href="?">栏目管理</a>
            </p>
        </div>
    	<div class="right clr">


            <div class="zhengwen clr">
             	<div class="zhixin clr"></div>
                 <div class="neirong clr">
                	<table cellpadding="0" cellspacing="0" class="table clr">
                        <tr class="first">
						<td width="11%">栏目ID</th>
						<td width="31%">栏目名称</th>
						<!-- <td width="14%">栏目类型</th> -->
						<td width="12%">数据量</th>
						<td width="22%">管理操作</th>
                        </tr>
<?php

	//树型结构类
	$tree = new Tree(M('news_cats')->order('id asc')->select());
	//实现无限极分类
	   $cate = $tree->spanning();
	   $dropdown =  '<select name="pid" id="" class="select1">%s</select>';
	   $option = '<option value="0">无（属一级栏目）</option>';
	   $color = array('#0B0000','#0E8A5F','#7FD7A2');
	   $spancer = array('','&nbsp;├','&nbsp;&nbsp;└└');
	   while( list(,$v) = each($cate) ):
	    $id  = $v['id'];
	   	$level = $v['level'];
	   	// dump($v);
		$pid = 0;
		$ty  = 0;
		$tty = 0;

	    if($level==0){
		    $pid = $id;
	    }elseif($level==1){
	    	$pid = $v['pid'];
	    	$ty  = $id;
	    }elseif($level==2){
	    	$tty = $id;
	    }
	   	$count = HR('news_cats')->where(array('pid'=>$pid,'ty'=>$ty,'tty'=>$tty))->count();
	    $showtype = $v['showtype'];
	    $showtemp = $webarr["showtype"][$showtype];
	    if($v['linkurl']){
	    	$showtemp = '自定义'.$v['linkurl'];
	    }
	   	$url  = getUrl(array('pid'=>$pid,'ty'=>$ty,'tty'=>$tty),'../list');
	   	$display = $level == 0 ? 'table-row' : 'none';//一级显示,其余隐藏


		$img1 = $level == 1 && $v['img1'] ? '<img src="'.src($v['img1']).'" width="80" alt="">' : '';//二级图片
		$img2 = $level == 1 && $v['img2'] ? '<img src="'.src($v['img2']).'" width="80" alt="">' : '';//二级图片
		$img3 = $level == 1 && $v['img3'] ? '<img src="'.src($v['img3']).'" width="80" alt="">' : '';//二级图片
 ?>
             <tr class="cat<?=$level?>">
             	 <td><?=$v['id']?></td>
                 <td align="left" class="tl"><?=$spancer[$level]?><?=$v['catname']?><?php echo $img1,$img2,$img3 ?></td>
                 <td><?=$count?></td>
                 <td>
                 	<?php if ($level==1&&($v['iscats']==1)): ?> <a data-class="btn-warm" class="json <?=$v['isstate']==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=$webarr['isstate'][$v['isstate']]?></a><?php endif ?>
                 	<?php if ($level==0&&($v['iscats']==1)): ?> <a href="<?=getUrl(array('pid'=>$id),$showname.'_pro')?>" class="thick" style="color:red">添加子栏目</a> <?php endif ?>
                 	<?php if ($level==1): ?> <a href="<?=getUrl($id,$showname.'_pro')?>" class="thick edits">编辑</a> <?php endif ?>
                 	<?php if ($level==1&&$v['iscats']==1): ?> <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a> <?php endif ?>
                 </td>
             </tr>
<?php endwhile; $pagestr=''?>
<?php include('js/foot'); ?>