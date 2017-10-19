<?php
require '../../core/run.php';

$data = M('news_cats')->field('id,path,showtype')->where('`catname`<>"辅助栏目" and `pid`=0')->order('id asc')->select();

define('HOME_PATH', APP_PATH . 'home' . DS);
define('APPS', APP_PATH . 'app' . DS);

$html = new Html;
$var = '';
foreach ($data as $key => $row) {
	extract($row);
	$class = ucfirst($path);
	$ty = getNextId($id);
	$tys = M('news_cats')->where('pid='.$id)->getField('id,catname',true);
	$tysif = '';
	foreach ($tys as $rty => $catname) {
		$tysif .= "<?php elseif (\$ty==$rty): //$catname ?>\n";
	}
	$tysif .= '<?php endif ?>';
	$var .= <<<T
	'$path' => $id, \n
T;
// 所有列表页
$indexTpl = <<<T
<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php innerBanner() ?>
<?php echo $class::index() ?>
<?php //\$obj =  new V(\$pid,\$ty) ?>
<?php \$obj =  Showtype::dispatch() ?>
$tysif
	<ul>
		<?php echo \$obj->display ?>
	</ul>
	<ul>
		<?php echo \$obj->pagestr ?>
	</ul>
<?php include FOOT ?>
T;
$detailTpl = <<<T
<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php innerBanner() ?>
<?php $class::view(\$id, '$path') ?>
<?php include FOOT ?>
T;
	$index = gPath($path, 'index');
	$detail = gPath($path, 'detail');
	$html->createdir($index);
	if ($showtype == 2) {
		$html->string($indexTpl)->saftSave($index);
	} else {
		$html->string($indexTpl)->saftSave($index);
		$html->string($detailTpl)->saftSave($detail);
	}

	#生成APPS
	$html->open('tpls/class/app.default.tpl');
	$html->strings = str_replace(tplVar('app'), [$class,$id,$ty,$path], $html->strings);
	$html->saftSave(APPS . $class . EXT);

}
// 创建首页
$html->createdir(gPath('index', 'index'));
// 创建关联url
$var = <<<T
<?php\n
	// 目录与pid的关联 如要访问pid=1,则用他对应的key值
	return [
$var
];\n
T;
#生成首页
$html->open('tpls/class/app.index.tpl')->saftSave(HOME_PATH . 'index/index' . EXT);
$html->string($var)->saftSave(HOME_PATH . 'map' . EXT);
#生成头部底部
$html->open('tpls/home/doctype.tpl')->saftSave(HOME_PATH . 'doctype' . EXT);
$html->open('tpls/home/foot.tpl')->saftSave(HOME_PATH . 'foot' . EXT);
$html->open('tpls/home/head.tpl')->saftSave(HOME_PATH . 'head' . EXT);
$html->open('tpls/home/processing.tpl')->saftSave(HOME_PATH . 'processing' . EXT);

#生成详情的模板
$html->createdir(HOME_PATH . 'public/x');
$html->open('tpls/publicView/1.tpl')->saftSave( gPath('public',1) );// 新闻详情
$html->open('tpls/publicView/2.tpl')->saftSave( gPath('public',2) );// 带推荐的详情
#生成默认APPS
$html->open('tpls/class/app.message.tpl')->saftSave(APPS . 'Message' . EXT);
$html->open('tpls/class/app.search.tpl')->saftSave(APPS . 'Search' . EXT);
// 各类型列表类
$html->open('tpls/class/Showtype.tpl')->saftSave(APPS . 'Showtype' . EXT);
$html->open('tpls/class/V.tpl')->saftSave(APPS . 'V' . EXT);
$html->open('tpls/class/View.tpl')->saftSave(APPS . 'View' . EXT);
$html->open('tpls/class/NewsList.tpl')->saftSave(APPS . 'NewsList' . EXT);
$html->open('tpls/class/SingleInformation.tpl')->saftSave(APPS . 'SingleInformation' . EXT);
$html->open('tpls/class/PictureList.tpl')->saftSave(APPS . 'PictureList' . EXT);


echo '初始化完成!';
// 只需一次
cookie('web_manage_init2', true);

function gPath($c, $m)
{
	return HOME_PATH . $c .DS. $m . EXT;
}
// 生成HOME文件夹
function tplVar($type)
{
	switch ($type) {
		case 'app':
			$tpl = ['_CLASS_', '_PID_', '_TY_', '_CONTROLLER_'];
			break;
		default:
			$tpl = [];
			break;
	}
	return $tpl;

}

//id 格式：获取当前分类的第一子分类id  不可删 header调用
function getNextId($pid,$table="news_cats")
{

	if($id=M($table)->where(array('isstate'=>1,'pid'=>$pid))->order('disorder desc,id asc')->getField('id')){
		unset($pid,$table);
		return $id;
	}else{
		return 0;
	}
}