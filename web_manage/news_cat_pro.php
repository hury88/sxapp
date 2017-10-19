<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';


$id       = I('get.id',0,'intval');
$table    = 'news_cats';
$showname = 'news_cat';
$parentid = I('get.pid',0,'intval');
$classname = '栏目管理';
if($id){
	$row = M($table)->find($id);
	extract($row);
	$classname = v_news_cats($id,'catname');
	$parentid = $pid;
	// if($row['ty'])$parentid = $row['ty'];
}
//树型结构类
$tree = new Tree(M($table)->field('id,pid,catname')->order('id asc')->select());
//下拉实例
// $spaces = array();
   $cate = $tree->spanning();
   $dropdown =  '<select name="pid" id="" class="select1">%s</select>';
   $option = '<option value="0">无（属一级栏目）</option>';
   while( list(,$v) = each($cate) ){
   	if(isset($parentid) && $parentid == $v['id']){

	   	$status  = 'selected';

   	}else{

	   	$status  = '';
   	}
   	$pre = str_repeat('&emsp;∞||&emsp;', $v['level']);
   	$option .= "<option $status value=\"{$v['id']}\">$pre{$v['catname']}</option>";
   }
   $dropdown = sprintf($dropdown,$option);
   unset($pre,$status,$option,$v,$cat);
$opt = new Output;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>栏目管理</title>
	<?php define('IN_PRO',1);include('js/head'); ?>
</head>

<body>


	<div class="content clr">
		<div class="right clr">
			<div class="zhengwen clr">
				<div class="xuanhuan clr">
					<a href="javascript:void()" class="zai" style="margin-left:30px;min-width:260px"><?=$classname?></a>
					<a href="#">SEO设置</a>
				</div>

				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output();Style::submitButton() ?>
						<input type="hidden" name="pid" value="<?=$parentid?>" />
						<input type="hidden" name="ty"  value="<?=$ty?>"  />
						<input type="hidden" name="tty" value="<?=$tty?>" />

						<?php if ($parentid<>0): ?>
						  <div class="layui-form-item">
							  <label title="" class="layui-form-label">所属栏目<b>*</b></label>
							  <div class="layui-input-block">
							 	 <b><?php echo v_news_cats($id,'catname') ?></b>
							  	 <?php //=$dropdown?>
							  </div>
						 </div>
						<?php endif ?>
						<?php $opt->cache()->input('类别名称','catname')->verify('')->input('英文名称','catname2')->flur()->hide('showtype')
							->ifs($pid==3)->img('配图','img1','384X257')->textarea('列表简介', 'contentTemplate')->endifs()
							->ifs($pid==2 || $pid==3)->img('目录图标','img2','69*67')->img('鼠标经过目录图标','img3','71*72')->endifs();
						?>

						<?php //$opt->choose('类型','showtype')->radioSet($webarr['showtype'])->flur() ?>
						<?php //$opt->display('inline')->verify('')->input('图片尺寸','imgsize') ?>
						<?php //$opt->cache()->verify('')->input('内部跳链','linkurl')->input('外部链接','weblinkurl')->flur() ?>
						<?php //$opt->choose('开放分类','iscats')->radio('关闭',0,2)->radio('开放',1)->flur() ?>
						<?php define('DEL_TIME_SORT',1) ?>
						<div class="miaoshu hide clr">
							<?php $opt->verify('')->input('页面标题','seotitle'); ?>
							<?php $opt->verify('')->input('页面关键字','keywords'); ?>
							<?php $opt->verify('')->textarea('页面描述','description'); ?>
						</div>
<?php include('js/foot'); ?>