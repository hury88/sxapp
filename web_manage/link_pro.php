<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'news';

$istop = I('get.istop',0,'intval');
$istop2 = I('get.istop2',0,'intval');
$showname='link';
if (!empty($id) ) { //显示页面 点击修改  只传了id
	$row = HR('news')->find($id);
	extract($row);
}
$opt = new Output;//输出流  输出表单元素
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>轮播,友情,图片,文件下载合用页面</title>
	<?php define('IN_PRO',1);include('js/head'); ?>
</head>
<body>
	<div class="content clr">
		<?php Style::weizhi() ?>
		<div class="right clr">
			<div class="zhengwen clr">
				<div class="xuanhuan clr">
					<a href="javascript:void()" class="zai" style="margin-left:30px;"><?=v_news_cats($zid,'catname')?></a>
				</div>

				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output();Style::submitButton() ?>
						<input type="hidden" name="pid" value="<?php echo $pid?>" />
						<input type="hidden" name="ty"  value="<?php echo $ty?>"  />
						<input type="hidden" name="tty" value="<?php echo $tty?>" />
						<?php
							switch ($showtype) {
								case 3://＜＞＜＞图片列表＜＞＜＞
									$opt
										->img('配图','img1')
										->input('标题','title')
										->editor()
										// $d = M('news')->where('pid=2 and ty=13 and tty=0')->getField('id,title');Output::select($d,'产品列表','tty')
									;break;
								case 4://＜＞＜＞友情链接＜＞＜＞
									$opt
										// ->img('配图','img1')
										->input('名称','title')
										->verify('')->input('跳链','linkurl')
										->verify('')->textarea('备注','content')
									;break;
								case 5://＜＞＜＞关联单条信息＜＞＜＞
									$count=M('news')->where("pid=$pid and ty=$ty and tty=$tty and tty<>0")->count();
									$opt
										// ->echoString('<li>温馨提示:<b>正在添加'.(++$count).'天行程</b> <br /></li>')
										->hide('istop')
										// ->word('请加上第几天')->input('年月','title')
										->cache()->input('年','title')->input('月','ftitle')->flur()
										->textarea('内容','content')
										// ->editor()
									;break;
								case 6://＜＞＜＞轮播图片＜＞＜＞
									$opt
										->img('图','img1')
										->verify('')->input('标题','title')
										->verify('')->input('链接地址','linkurl')
										// ->hide('istop')
									;break;
								case 8://＜＞＜＞文件下载＜＞＜＞
									$opt
										->img('图','img1')
										->input('标题','title')
										// ->textarea('介绍','content')
										->editor('细节图','content2')
										->editor('介绍','content','',100)
										->file('文件','file')
										->verify('')->word('使用外链说明:填写上文件的下载地址,在后台对应列表页切换为外链下载')->input('链接地址','linkurl')
									;break;
							}

							include('js/foot')
						 ?>
