<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'news';
$showname = 'master';
$opt = new Output;
?>
<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="UTF-8" />
	<title>参考写法</title>
	<?php define('IN_PRO',1);include('js/head'); ?>

</head>

<body>


	<div class="content clr">
		<div class="right clr">
			<div class="zhengwen clr">

				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<!-- 表单提交 -->
						<form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
							<?php Style::output();?>
							<?php

							$on = 1;

							// 下拉框 $d = M('news')->where('pid=1 and ty=7')->getField('id,title');

							// 构造数组
							$d = [
							0 => '数据零',
							1 => '数据一',
							2 => '数据二',
							3 => '数据三',
							4 => '数据四',
							5 => '数据五',
							6 => '数据六',
							];
							Output::select($d,'下拉框','on');
							echo '<input type="hidden" value="Output::select($d,\'下拉框\',\'on\')">';

							//复选框
							// $d = M('news')->where(m_gWhere(14,19))->getField('id,title');
							$opt->choose('复选框','on')->checkboxSet($d)->flur();
							echo '<input type="hidden" value="$opt->choose(\'复选框\',\'on\')->checkboxSet($d)->flur();">';



							#单选框
							// 说明 '木纹',1 1:代表值
							$opt->choose('单选框一','on')->radio('木纹',1, Output::CHECKED)->radio('石纹',2)->flur();
							echo '<input type="hidden" value="$opt->choose(\'单选框一\',\'on\')->radio(\'木纹\',1, Output::CHECKED)->radio(\'石纹\',2)->flur();">';
							$opt->choose('单选框二','on')->radioSet($d)->flur();// 常用
							echo '<input type="hidden" value="$opt->choose(\'单选框二\',\'on\')->radioSet($d)->flur();// 常用">';
							#图片上传
							$opt->img('图片一', 'on')->img('图片二', 'on', $ty)->img('图片三', 'on', '1080*1920');
							#文件上传
							$opt->file('文件上传','on');
							#输入框
							$on = '$opt->img(\'图片一\', \'on\')->img(\'图片二\', \'on\', $ty)->img(\'图片三\', \'on\', \'1080*1920\');'."-----------------------".'$opt->file(\'文件上传\',\'on\');';
							// $on = "\$opt->display('block')->word('')->input('输入框长的', 'on');";
							$opt->display('block')->word('dipplay可省略')->input('输入框长的', 'on');// display可省略 默认是长的
							echo '<input type="hidden" value="$opt->display(\'block\')->word(\'dipplay可省略\')->input(\'输入框长的\', \'on\');// display可省略 默认是长的">';

							$on = '';
							// $on = "\$opt->display('inline')->word('短的,但独占一行')->input('输入框短的', 'on');";
							$opt->display('inline')->word('短的,但独占一行')->input('输入框短的', 'on');
							echo '<input type="hidden" value="$opt->display(\'inline\')->word(\'短的,但独占一行\')->input(\'输入框短的\', \'on\');">';

							// $on = "\$opt->cache()->word('短的,都在一行')->input('输入框', 'on')->input('同一行', 'on')->input('同一行', 'on')->flur()";
							$on = time();
							$opt->cache()->word('这是一个时间选择框')->time('时间选择框', 'on')->word('短的,都在同一行')->input('同一行', 'on')->input('同一行', 'on')->flur();
							echo '<input type="hidden" value="$opt->cache()->word(\'这是一个时间选择框\')->time(\'时间选择框\', \'on\')->word(\'短的,都在同一行\')->input(\'同一行\', \'on\')->input(\'同一行\', \'on\')->flur();">';

							#文本域
							$opt->word('请用"|"隔开')->textarea('文本域', 'on');
							echo '<input type="hidden" value="$opt->word(\'请用\'|\'隔开\')->textarea(\'文本域\', \'on\');">';
							#编辑器
							$opt ->editor('信息内容', 'content');
							echo '<input type="hidden" value="$opt ->editor(\'信息内容\', \'content\')">';
							?>

							<script>
								$('.layui-form-item').click(function(){
									var nextIpt = $(this).next('input');
									var nxtIptTp = nextIpt.attr('type');
										layer.open({
										  type: 1,
										  title: '',
										  skin: 'layui-layer-rim', //加上边框
										  area: ['420px', '240px'], //宽高
										  content : nextIpt.val(),
										  shadeClose: true,
										});
									/*if ('hidden' == nxtIptTp) {
										nextIpt.attr('type', 'text');
									} else {
										nextIpt.attr('type', 'hidden');
									}*/
								})
							</script>

							<div class="layui-form-item">
								<div class="layui-inline">
									<label class="layui-form-label">信息排序</label>
									<div class="layui-inline">
										<input type="text" value="<?=isset($disorder) ? $disorder : 0 ?>" name="disorder" autocomplete="off" class="layui-input">
									</div>注：数字越大越排在前
								</div>
								<div class="layui-inline">
									<label class="layui-form-label">发布时间</label>
									<div class="layui-input-inline">
										<input type="text" name="sendtime" placeholder="点击文本框选择日期" autocomplete="off" class="layui-input" value="<?=isset($sendtime)? date("Y-m-d H:i:s",$sendtime) : date("Y-m-d H:i:s") ?>" onclick="layui.laydate({elem: this,format: 'YYYY-MM-DD hh:mm:ss'})">
									</div>
								</div>
							</div>
						<?php //Style::submitButton(); ?>
						<!-- 必须隐藏域开始 -->
						<input type="hidden" name="id" value="<?=$id?>">
						<input type="hidden" name="t" value="<?=$table?>">
						<!-- 必须隐藏域结束 -->
					</form> </div> </div> </div> </div> </div> </body> </html>

					<script>
					layui.use(['form', 'layedit', 'laydate'], function() {
						var form = layui.form(),
						layer = layui.layer,
						laydate = layui.laydate;
						 	  				//自定义验证规则
						 	  				form.verify({
						 	  					title: function(value) {
						 	  						if(value.length < 5) {
						 	  							console.log(this.title);
						 	  							return $(this).name+'至少得5个字符啊';
						 	  						}
						 	  					},
						 	  					pass: [/(.+){6,12}$/, '密码必须6到12位'],
						 	  				});
						 	  				//监听提交
						 	  				form.on('submit(demo1)', function(data) {
						 	  					submitForm();return false;
						 	  				});
						 	  			});
					</script>

					<!-- 公用的功能 -->
					<script>
					$('img,.img').on('click', function () {
						$src  = this.src;
						layer.open({
							title: false,
							type: 1,
							content: '<img width="100%" src="'+$src+'" />',
							area: ['auto', 'auto'],
							shadeClose: true
						});
					});
					</script>

