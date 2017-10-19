<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';


$id       = I('get.id',0,'intval');
$table    = 'news_cats';
$showname = 'class_cat';
$parentid = I('get.pid',0,'intval');
$classname = '栏目管理';

#[批量导入]
if (isset($_POST['importField'])) {
	if (! $parentid) {Redirect::JsError('没有找到父级!');die;}
	$yiji = $_POST['importField'];
	if ( $yiji) {
		$yiji_s = explode("\r\n", $yiji);
		$showtype = M($table)->where("id=$parentid")->getField('showtype');
		foreach ($yiji_s as $key => $value) {
			M($table)->insert(array(
				'pid' => $parentid,
				'catname' => trim($value),
				'showtype' => $showtype,
				'isstate' => 1,
			));
		}
		Redirect::JsSuccess('导入OK!', Request::instance()->url());
	}
	Redirect::JsError('栏目不能为空');
	die;
}



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
	<title>超级栏目管理</title>
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
			    		<form class="hide" id="imports" method="post">
				    		<textarea name="importField" id="" cols="30" rows="10"></textarea>
				    		<input type="hidden" name="pid" value="<?=$parentid?>"/>
				    		<input type="submit" value="导入">
			    		</form>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output(); ?>  <input type="hidden" name="pid" value="<?=$parentid?>" /> <input type="hidden" name="ty"  value="<?=$ty?>"  /> <input type="hidden" name="tty" value="<?=$tty?>" />
						<div class="layui-form-item">
							<div class="layui-input-block">
								<input type="button" class="datasubmit layui-btn" style="background-color:#2964ad"  lay-submit lay-filter="demo1" value="立即提交" />
								<input type="reset" class="layui-btn layui-btn-primary" value="重置">
								<a href="<?=$showname.'_pro.php?'.queryString(0,0)?>" class="layui-btn layui-btn-primary"><i class="layui-icon"> ဂ</i></a>
								<a onclick="$('#imports').toggle()"  class="layui-btn layui-btn-primary">批量加入</a>
							</div>
						</div>
						  <div class="layui-form-item">
							  <label title="" class="layui-form-label">所属分类<b>*</b></label>
							  <div class="layui-input-block">
							  	<?=$dropdown?>
							  </div>
						 </div>
						<?php $opt
							->cache()->input('类别名称','catname')->verify('')->input('英文名称','catname2')->flur()
							->choose('类型','showtype')->radioSet(Config::get('webarr.showtype'))->flur()
							->display('inline')->verify('')->input('图片尺寸','imgsize')
							->verify('')->textarea('模板','tpl')
							->cache()->verify('')->input('内部跳链','linkurl')->input('外部链接','weblinkurl')->flur()
							->choose('开放分类','iscats')->radio('关闭',0,2)->radio('开放',1)->flur();
							define('DEL_TIME_SORT',1);
						?>
						<div class="miaoshu hide clr">
							<?php
								$opt
								->verify('')->input('页面标题','seotitle')
								->verify('')->input('页面关键字','keywords')
								->verify('')->textarea('页面描述','description')
							 ?>
						</div>

<?php include('js/foot'); ?>