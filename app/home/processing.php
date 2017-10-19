<?php
$temp = strtoupper(urldecode(urldecode($_SERVER['REQUEST_URI'])));
if(strpos($temp, '<') !== false || strpos($temp, '"') !== false || strpos($temp, 'CONTENT-TRANSFER-ENCODING') !== false)
{
  exit('非法操作');
}
unset($temp);

if($system_isstate==1)exit($system_showinfo);

{
  $q  = I('get.q', '', 'trim');
  sql_filter($q);
  $q = cutstr($q, 20);//关键字
}
$id  = I('get.id' , 0, 'intval');
$pid = I('get.pid', 0, 'intval');
$ty  = I('get.ty' , 0, 'intval');
$category_id_1  = I('get.category_id_1' , 0, 'intval');$category_id_1 && $ty=$category_id_1;
$tty = I('get.tty', 0, 'intval');

if (!$map = Config::get('map')) {
  die(Config::get('r404'));
}

$pid = isset($map[$controller]) ? $map[$controller] : 0;


$table = 'news';

//排除辅助栏目
// if($pid === NavSet::fuzhuId()) header('location:/');

//SEO友好
$showtype = 0;

if($id && $view = View::dispatch($id, $controller, $method)) {
  $pid = $view->pid;
  $ty = $view->ty;
  $id_title = $view->title;
  $system_seotitle     = isset($view->seotitle) ? $view->seotitle : $view->title;
  $system_keywords     = isset($view->keywords) ? $view->keywords : '';
  $system_description  = isset($view->description) ? $view->description : '';
} elseif($pid || $ty) {
  if(!$ty) $ty=getNextId($pid);
  $pid_find = M('news_cats')->field('keywords,img1,description,seotitle,catname,showtype')->find($pid);
  $pid_img1 = $pid_find['img1'];
  $pid_find = M('news_cats')->field('keywords,img1,description,seotitle,catname,showtype')->find($ty);
  $showtype=$pid_find['showtype'];
  $system_seotitle     = $pid_find['seotitle'] ? $pid_find['seotitle'] : $pid_find['catname'];
  $system_keywords     = $pid_find['keywords'];
  $system_description  = $pid_find['description'];
  // unset($pid_find);
} elseif($q) {
  $news_cats_ty_catname='搜索"'.$q.'"的结果';
}

$pidNewsCatsTmp = M('news_cats')->find($pid);
$tyNewsCatsTmp  = M('news_cats')->find($ty);
$tyNewsTmp      = M('news')->where("pid=$pid and ty=$ty")->find();
$pidNewsCatsTmp && extract($pidNewsCatsTmp,EXTR_PREFIX_ALL,'pid');
$tyNewsCatsTmp  && extract($tyNewsCatsTmp,EXTR_PREFIX_ALL,'news_cats_ty');
if ($q && isset($news_cats_ty_catname)) {$news_cats_ty_catname='搜索"'.$q.'"的结果';}
$tyNewsTmp      && extract($tyNewsTmp,EXTR_PREFIX_ALL,'news_ty');
unset($bd,$pidNewsCatsTmp,$tyNewsCatsTmp,$tyNewsTmp);

$system_keywords    = isset($id_keywords)    ? $id_keywords    : $system_keywords;
$system_description = isset($id_description) ? $id_description : $system_description;
$system_seotitle    = trim("$system_seotitle | $system_sitename", ' | ');

// 内页banner图
$pid_img1 = isset($pid_img1) && $pid_img1 ? src($pid_img1) : '/style/images/banner0.jpg';
$qq_online = 'http://wpa.qq.com/msgrd?v=3&uin='.$system_webqq.'&site=qq&menu=yes';

/*
switch ($showtype) {
  case '2':
    if ($controller <> 'contactus') {
      $path = 'content/index';
    }
    break;
  default:
    break;
}*/
