<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'news_cats';
$showname = 'class_cat';
$showtypeSet = Config::get('webarr.showtype');


if(IS_POST){
	//批量导入
	if (isset($_POST['importField'])) {
		$yiji = $_POST['importField'];
		if ( $yiji) {
			$yiji_s = explode("\r\n", $yiji);
			foreach ($yiji_s as $key => $value) {
				if (!strpos($value, ' ')) {
					$value .= ' ';
				}
				list($v1,$v2) = explode(' ',$value,2);
				// dump($value);
				M($table)->insert(array(
					'pid' => 0,
					'catname' => $v1,
					'path' => $v2,
					'isstate' => 1,
					'showtype' => 1,
				));
			}
			Redirect::JsSuccess('导入OK!', Request::instance()->url());
		}
		Redirect::JsError('栏目不能为空');
		die;
	}
	$catname = I('post.catname','');
	$field = I('post.field','');
	if(isset($_POST['showtype'])){
		$field = 'showtype';
		$catname = I('post.showtype',0,'intval');
		$back = $showtypeSet[$catname];
	}else{
		$field = $field;
		$back = $catname;
	}
	$id = I('post.id',0,'intval');

	if(M('news_cats')->where("id=$id")->setField($field,$catname)){
		echo($back);
	}else{
		echo(-1);
		// ECHO(C('HR')->getLastSql());
	}
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>栏目管理</title>
	<?php include('js/head'); ?>
	<script>
		$(function(){
			$('.cat0').children('td:not(.tl)').click(function(){
				// $(this).parent('.cat0').siblings('.cat0').nextAll('.cat1,.cat2').hide();
				$(this).parent('.cat0').nextUntil('.cat0').toggle();
				// $(this).parent('.cat0').nextAll('.cat2').hide();
			})

			$('.cat1').children('td:not(.tl)').click(function(){
				$(this).parent('.cat1').nextUntil(':not(.cat2)').toggle();
			})

			$('.edit').click(function(e){
				e.stopPropagation();
				$(this).hide();
				$(this).next('.catname').show();
				$(this).next('.catname').focus();
			})


			$('.catname').click(function(e){
				e.stopPropagation();
			})
			$('.catname').blur(function(){
				that = $(this);
				var val = that.val()//要修改的值
				var cid = that.prev('.edit').data('id')
				var fieldVal = that.prev('.edit').data('catname')
				if(val==that.prev('.edit').text()){
					that.hide();
					that.prev('.edit').show();
				}else{
					$.post('class_cat.php',{catname:val,field:fieldVal,id:cid},function(data){
						if(data!=-1){
							that.hide();
							that.prev('.edit').show().text(data);
						}else{
							alert('修改失败')
							that.hide();
							that.prev('.edit').show();
						}

					})
				}

			})

			$('.edit2').click(function(e){
				e.stopPropagation();
				$(this).hide();
				$(this).next('.showtype').show();
				$(this).next('.showtype').focus();
			})


			$('.showtype').click(function(e){
				e.stopPropagation();
			})
			//显示方式 下拉框
			$('.showtype').blur(function(){
				that = $(this);
				var val = that.val()//要修改的值
				var cid = that.prev('.edit2').data('id')
				if(val==that.prev('.edit2').data('type')){
					that.hide();
					that.prev('.edit2').show();
				}else{
					$.post('class_cat.php',{showtype:val,id:cid},function(data){
						if(data!=-1){
							that.hide();
							that.prev('.edit2').show().text(data);
						}else{
							that.hide();
							that.prev('.edit2').show();
						}

					})
				}
			})
		})
	</script>
	<style>
		tr.cat0 td,tr.cat0 td a,
		tr.cat1 td,tr.cat1 td a
		 {
			-webkit-transition: all .5s;
			-o-transition: all .5s;
			transition: all .5s;
			color:white;

		}
		tr.cat2 td,tr.cat2 td a{
			-webkit-transition: all .5s;
			-o-transition: all .5s;
			transition: all .5s;
			color:#000;
		}
		tr.cat0 td   {text-align: left;}
		tr.cat1 td   {text-align: center;}
		tr.cat2 td   {text-align: right;}

		tr.cat0 td a:hover,
		tr.cat1 td a:hover
		 {
			color:white;
			font-size: 15px;
			font-weight:bold;
		}
		tr.cat2 td a:hover{
			color:#fff;
			font-weight:bold;
			font-size: 15px;
		}
	</style>
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
	    		<form class="hide" id="imports" method="post">
		    		<textarea name="importField" id="" cols="30" rows="10"></textarea>
		    		<input type="submit" value="导入">
	    		</form>
					<section class="fl">
					  <a href="?">刷新</a>
					  <a id="adda" href="javascript:;">添加</a>
					  <a onclick="$('#imports').toggle()">批量加入</a>
					</section>
					<section>
					<?php
						$showtype1 = config('webarr.showtype');
						$showtype2 = config('webarr.showtype2');
						foreach ($showtype1 as $key => $value) {
							$ids = M($table)->where(['showtype'=>$key, 'pid' => 0, 'catname' => ['neq',"辅助栏目"]])->getField('id',true);$ids or $ids = [];
							// $ids2 = M($table)->where(['showtype'=>$key, 'pid' => ['neq',0] ])->getField('id',true);$ids2 or $ids2 = [];
							$ids = implode(',', $ids);
							// $ids2 = implode(',', $ids2);
							echo "<b style=color:red>(</b>$value(pid:$ids):$key=>$showtype2[$key]<b style=color:red>)</b><br>";
						}
					 ?>
					 </section>
					 <!-- <a href="class_cat_pro.php" target="righthtml" class="zhixin_a3 fl"></a> -->
	            <div class="zhengwen clr">
	             	<div class="zhixin clr"></div>
	                 <div class="neirong clr">
	                	<table cellpadding="0" cellspacing="0" class="table clr">
	                        <tr class="first">
							<td width="24px">栏目ID</td>
							<td width="24px">栏目名称</td>
							<td width="24px">栏目名称2</td>
							<td width="24px">栏目类型</td>
							<td width="24px">图片尺寸</td>
							<td width="24px">路径</td>
							<td width="24px">数据量</td>
							<td width="24px">分页数</td>
							<!-- <td width="24px">访问</td> -->
							<td width="24px">审核</td>
							<td width="124px">管理操作</td>
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
		    $showtemp = $showtypeSet[$showtype];
		    if($v['linkurl']){
		    	$showtemp = '自定义'.$v['linkurl'];
		    }
		   	$url  = getUrl(array('pid'=>$pid,'ty'=>$ty,'tty'=>$tty),'../list');
		   	$display = $level == 0 ? 'table-row' : 'none';//一级显示,其余隐藏

	 ?>
	             <tr class="cat<?=$level?>" style="display:<?=$display?>;background:<?=$color[$level]?>">
	             	 <td><?=$v['id']?></td>
	                 <td align="left" class="tl"><?=$spancer[$level]?>
	                 	<span data-id="<?=$id?>" style="display:inline-block" data-catname="catname" class="edit"><?=$v['catname']?></span>
	                 	<input class="catname" style="width:50%;height:100%;font-size:20px;display:none"  value="<?=$v['catname']?>" type="text" />
	                 </td>
	                 <td align="left" class="tl"><?=$spancer[$level]?>
	                 	<span data-id="<?=$id?>" style="display:inline-block;min-width:20px;min-height:20px;background:white;color:#000" data-catname="catname2" class="edit"><?=$v['catname2']?></span>
	                 	<input class="catname" style="width:50%;height:100%;font-size:20px;display:none"  value="<?=$v['catname2']?>" type="text" />
	                 </td>
	                 <td class="tl">
	                 	<span data-id="<?=$id?>" style="display:inline-block;" data-catname="showtype" data-type="<?=$showtype?>" class="edit2"><?=$showtemp?></span>
	                 	<select style="display:none" name="showtype" class="showtype">
								<option value="0">选一个</option>
	                 		<?php foreach ($showtypeSet as $key => $value): $sl = $key==$showtype? 'selected': ''; ?>
								<option <?=$sl?> value="<?=$key?>"><?=$value?></option>
	                 		<?php endforeach ?>
	                 	</select>
	                 </td>
	                 <td>
	                 	<span data-id="<?=$id?>" style="display:inline-block;min-width:20px;min-height:20px;background:white;color:#000" data-catname="imgsize" class="edit"><?=$v['imgsize']?></span>
	                 	<input class="catname" style="width:50%;height:100%;font-size:20px;display:none"  value="<?=$v['imgsize']?>" type="text" />
	                 	<?//=$v['imgsize']?>
	                 </td>
	                 <td>
	                 	<span data-id="<?=$id?>" style="display:inline-block;min-width:20px;min-height:20px;background:white;color:#000" data-catname="path" class="edit"><?=$v['path']?></span>
	                 	<input class="catname" style="width:50%;height:100%;font-size:20px;display:none"  value="<?=$v['path']?>" type="text" />
	                 </td>
	                 <td>
	                 	<span data-id="<?=$id?>" style="display:inline-block;min-width:20px;min-height:20px;background:white;color:#000" data-catname="pagesize" class="edit"><?=$v['pagesize']?></span>
	                 	<input class="catname" style="width:50%;height:100%;font-size:20px;display:none"  value="<?=$v['pagesize']?>" type="text" />
	                 </td>
	                 <td><?=$count?></td>
	                 <!-- <td><a href="<?=$url?>" target="_blank">访问</a></td> -->
	                 <td>
	                 	<section>
		                 	<a data-class="layui-btn-warm" class="json layui-btn <?=$v['isstate']==1?'':'layui-btn-warm' ?> layui-btn-small" data-url="s=1&a=isstate&t=<?=$table?>&id=<?=$id?>"><?=$v['isstate']==1?'已审核':'待审核' ?></a><br>
	                 	</section>
	                 </td>
	                 <td>
	                     <section>
	                         <a href="<?=getUrl($id,'../view')?>" target="_blank" class="thick">访问</a>
	                         <a href="<?=getUrl(array('pid'=>$id),$showname.'_pro')?>" class="thick">添加子栏目</a>
	                         <a href="<?=getUrl($id,$showname.'_pro')?>" class="thick edits">编辑</a>
	                         <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
	                     </section>
	                 </td>
	                 <!-- <td><a href="class_cat_pro.php?pid=<?=$id?>" >添加子栏目</a>&nbsp;|&nbsp;<a href="class_cat_pro.php?id=<?=$id?>">修改</a> -->
	                 	<!-- &nbsp;|&nbsp;<a href="<?=getUrl(array('action'=>'del','id'=>$id,'pid'=>$pid,'ty'=>$ty,'tty'=>$tty),false)?>" onClick="return ConfirmDelBig();">删除</a></td> -->
	             </tr>
	<?php endwhile; $pagestr=''?>
	<?php include('js/foot'); ?>
