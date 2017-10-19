<?php
require '../../core/run.php';
include 'library/Form.php';
$table = 'news_cats';
$data = M($table)->field('id,path,showtype')->where('`pid`<>0')->order('id asc')->select();

define('HOME_PATH', APP_PATH . 'home' . DS);
define('APPS', APP_PATH . 'app' . DS);

$html = new Html;
// 列出所有栏目
$form = new Form;

$var = '';
// foreach ($data as $key => $row) {
// 	// dump($row);
// }
?>
<!DOCTYPE html>
<html lang="en">
<script src="js/jquery.js"></script>
<head>
	<meta charset="UTF-8">
</head>
<body class="form">
	<?php $html->getClassList('pid=0') ?>
	<input type="text" name="function" placeholder="函数名">
	<button onclick="return model(this,'model/gode.php')">生成</button>
	<textarea id="textarea" cols="60" rows="15"></textarea>
	<br><br>
	<?php
		$data = load_config('config/gode.json');
		$tmp = [];
		foreach ($data as $key => &$value) {
			$value = $value[0];
		}
		$form->choose('选择模板', 'tpl')->radioSet($data)->flur();
	 ?>
</body>
</html>

