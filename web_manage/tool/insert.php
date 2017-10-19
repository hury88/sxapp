<?php
require '../../core/run.php';

$table = 'news_cats';
$data = M($table)->field('id,path,catname,showtype')->where('`catname`<>"辅助栏目" and `pid`=0')->order('id asc')->select();

define('HOME_PATH', APP_PATH . 'home' . DS);
define('APPS', APP_PATH . 'app' . DS);

foreach ($data as $key => $row) {
	extract($row);
	if (M($table)->where("pid=$id")->find()) {
		echo "$catname 已插->";
	} else {
		$insid = M($table)->insert(array(
			'pid' => $id,
			'catname' => $catname,
			'isstate' => 1,
			'showtype' => 1,
		));
		echo "$catname 插入一行子级->";
	}
}
$id = M($table)->where('catname="辅助栏目"')->getField('id');
if (M($table)->where("pid=$id")->find()) {
	echo "辅助栏目基本栏目已添加";
} else {
	#留言管理
	$insid = M($table)->insert(array(
		'pid' => $id,
		'catname' => '留言管理',
		'linkurl' => 'message.php',
		'isstate' => 1,
		'showtype' => 6,
	));
	#首页轮播
	$insid = M($table)->insert(array(
		'pid' => $id,
		'catname' => '首页轮播',
		'showtype' => 6,
		'isstate' => 1,
	));
	#内页banner
	$insid = M($table)->insert(array(
		'pid' => $id,
		'catname' => '内页banner',
		'linkurl' => 'ban.php',
		'isstate' => 1,
		'showtype' => 1,
	));
	echo "$catname 辅助栏目基本子级新添加";
}

// 只需一次
cookie('web_manage_init1', true);