<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = $showname = 'goods';
$category_id_1 = I('get.category_id_1', M('news_cats')->where('pid=1')->getField('id'), 'intval');
$category_id_2 = I('get.category_id_2', M('news')->where("ty=$category_id_1")->getField('id'), 'intval');
if ($id) { //显示页面 点击修改  只传了id
	$row = M($table)->find($id);
	extract($row);
}else {
	$category_id_2 || Redirect::JsError('二级类目不存在,进入失败');
}
$opt = new Output;//输出流  输出表单元素
if (isset($_GET['action']) && $_GET['action']=='delImg') {
	$id = I('get.id',0,'intval');
	$img = I('get.img');
	$path = ROOT_PATH.I('get.path');
	M($table)->where("id=$id")->setField($img,'');
	@unlink($path);
	JsError('删除成功!');
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="UTF-8" />
	<title>新闻,产品,单条</title>
	<?php define('IN_PRO',1);include('js/head'); ?>
</head>

<body>


	<div class="content clr">
        <?php $classname = v_news_cats($category_id_1, 'catname') .'<span>></span>' . @v_id($category_id_2, 'title');Style::weizhi() ?>
		<div class="right clr">
			<div class="zhengwen clr">
				<div class="xuanhuan clr">
					<a href="javascript:void()" class="zai" style="margin-left:30px;"><?=v_id($category_id_2, 'title')?></a>
				</div>

				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output();Style::submitButton() ?>
						<input type="hidden" name="category_id_1" value="<?php echo $category_id_1?>" />
						<input type="hidden" name="category_id_2"  value="<?php echo $category_id_2?>"  />
<?php

	/*$opt->verify('')->input('页面标题','seotitle')->input('页面关键字','keywords')->textarea('页面描述','description');*/

		// (!isset($title) || ! $title ) && $title = $system_sitename . '官方公告';
	$d2 = M('news_cats')->where("id=$category_id_1")->getField('id,catname');Output::select($d2,'类目一','category_id_1');
	$d2 = M('news')->where('ty='.$category_id_1)->order('isgood desc, disorder desc, id asc')->getField('id,title');Output::select($d2,'类目二','category_id_2');
    $opt
		// $d = M('news')->where(m_gWhere(14,19))->getField('id,title');
		//单选框
		// ->choose('类型','istop')->radio('木纹',1,2)->radio('石纹',2)->flur()
		//复选框
		// ->choose('标签','relative')->checkboxSet($d)->flur()
		->img('主图','img1')
		->cache()->verify('')
			->input('商品名称', 'goods_name')
			->input('商品补充', 'goods_name_added')
			->input('规格', 'size')
		->flur()
		->cache()->verify('')
			->input('市场价', 'market_price')
			->input('商品原价格', 'price')
			->input('成本价', 'cost_price')
		->flur()
		->cache()->verify('')
			->input('销售数量', 'sales')
			->input('收藏数量', 'collects')
		->flur()
		->cache()
			->input('库存', 'stock')

		->flur()
		->editor('商品详情')
		// ->time('项目名','sendtime')
		// ->input('售价','price')->input('电话','name')->flur()
	;

	include('js/foot');

?>
