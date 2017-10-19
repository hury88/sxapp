<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'news';
$showname = 'master';

//条件
$map = array('pid'=>$pid,'ty'=>$ty,'tty'=>0);

###########################筛选开始
$id    =   I('get.id','','trim');if(!empty($id))$map['id'] = array('like',"%$id%");
$title =   I('get.title','','trim');if(!empty($title))$map['title'] = array('like',"%$title%");
$istop =   I('get.istop',0,'intval');if(!empty($istop))$map['istop'] = $istop;
$istop2 =  I('get.istop2',0,'intval');if(!empty($istop2))$map['istop2'] = $istop2;
if(!empty($tty)) $map['tty'] = $tty;
###########################筛选开始
########################分页配置开始
$psize   =   I('get.psize',30,'intval');
$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => 'isgood desc,disorder desc,sendtime asc',
    /*条数*/'psize' => $psize,
    /*表  */'table' => $table,
    );
list($data,$pagestr) = Page::paging($pageConfig);
########################分页配置结束
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<?php include('js/head'); ?>
</head>
<body>
	<div class="content clr">
        <?php Style::weizhi() ?>
        <div class="right clr">
          <form class="" id="jsSoForm">
            <input type="hidden" name="pid" value="<?=$pid?>" />
            <input type="hidden" name="ty"  value="<?=$ty?>"  />
            <input type="hidden" name="tty" value="<?=$tty?>" />
            <!-- <b>显示</b><input style="width:50px;" name="psize" type="text" class="dfinput" value="<?=$psize?>"/>条 -->
            <!-- <b>编号</b><input name="id" type="text" class="dfinput" value="<?=$id?>"/> -->
        <?php if ($ty==11): ?>
            <?php
                $d2 = M('news')->where('pid=1 and ty=24')->order(config('other.order'))->getField('id,title');Output::select2($d2,'法定节日','istop2');
             ?>
        <?php endif ?>
        关键字<input name="title" type="text" class="dfinput" value="<?=$title?>"/>
        <input name="search" type="submit" class="btn" value="搜索"/></td>
    </form>
    <div class="zhengwen clr">
      <div class="zhixin clr">
        <ul class="toolbar">
            <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
        </ul>
        <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a><!-- 刷新  -->
        <a href="<?=getUrl(queryString(true),$showname.'_pro')?>" target="righthtml" class="zhixin_a3 fl"></a><!-- 添加  -->
        <input id="del" type="button" class="zhixin_a4 fl"/><!-- 删除  -->
        <?php Style::moveback() ?>
        <?php if (false && 5 == $showtype): // || 3 == $pid ?>
        <a style="background:none;border:1px solid;line-height:28px;text-align:center" href="content.php?<?=queryString()?>" class="fl">编辑详情</a>
    <?php endif ?>
</div>
</div>
<div class="neirong clr">
    <table cellpadding="0" cellspacing="0" class="table clr">
       <tr class="first">
        <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
        <td width="24px">编号</td> <td width="200px">操作</td>

    <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/    if ($showtype==1):/*＜＞＜＞新闻＜＞＜＞*/?>
        <td width="24px"> 图 </td>
        <td> 标题 <span class="fr">发布者</span></td>
        <td> 点击量 </td>
        <!-- <td> 浏览次数 </td> -->
    <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==5):/*＜＞＜＞单条＜＞＜＞*/?>
        <td> 标题 </td>
        <!-- <td> 其它 </td> -->
    <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==9):/*＜＞＜＞产品＜＞＜＞*/?>
        <td width="24px"> 图 </td>
        <td> 名称 </td>
        <?php if ($ty==11): ?><td> 分类 </td><?php endif ?>
        <!-- <td> 浏览次数 </td> -->
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==10):/*＜＞＜＞产品分类＜＞＜＞*/?>
        <td width="24px"> 分类 </td>
        <td> 操作 </td>
    <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==11):/*＜＞＜＞图文列表＜＞＜＞*/?>
        <!-- <td width="24px"> 配图 </td> -->
        <td> 配图 </td>
        <td> 信息 </td>
    <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/endif?>
    <td width="10%">发布时间</td>
</tr>
<?php
    foreach ($data as $key => $bd) : extract($bd);

                            #生成修改地址
    $query = queryString(true);
    $query['id'] = $id;
    $editUrl = getUrl($query, $showname.'_pro');
                            #时间
    $time =  date('Y-m-d H:i',$sendtime);
    $img1 =  '<img src="'.src($img1).'" width="80" />';

    // $title = '<a href="' . U('blog/view', ['id'=>$id]) . '" target="_blank">'.$title.'</a>';
?>
<tbody>
    <tr>
        <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
        <td><?=$id?></td>
        <td>
            <a href="<?=$editUrl?>" class="thick ">编辑</a>|
            <?php if ($ty==10 || $showtype==1): //团队?>
                <a data-class="btn-warm" class="json <?=$istop==1?'btn-warm':'' ?>" data-url="isindex&id=<?=$id?>"><?=config('webarr.isindex')[$istop] ?></a>|
            <?php endif ?>
            <a data-class="btn-danger" class="json <?=$isgood==1?'btn-danger':'' ?>" data-url="isgood&id=<?=$id?>"><?=Config::get('webarr.isgood')[$isgood] ?></a>|
            <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=Config::get('webarr.isstate')[$isstate] ?></a>|
            <!-- <a href="<?=$editUrl?>" class="thick edits">编辑</a>| -->
            <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
        </td>
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/if ($showtype==1):/*＜＞＜＞新闻＜＞＜＞*/?>
        <td><?=$img1?></td>
        <td><?=$title?><span class="fr"><?php echo $name ?></span></td>
        <td><?=$hits?></td>
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==5):/*＜＞＜＞单条＜＞＜＞*/?>
            <td><?=$title?><!-- <span class="fr"><a href="link.php?showtype=6&istop=<?php echo $id ?>">下属列表</a></span> --></td>
            <!-- <td><a href="pic.php?ti=<?=$id?>">图集(<?php echo M('pic')->where("ti=$id and isstate=1")->count()?>条)</a></td> -->
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==9):/*＜＞＜＞产品＜＞＜＞*/?>
        <td><?=$img1?></td>
        <td><?=$title,'&emsp;',$ftitle,'&emsp;',$name?><a href="pic.php?ti=<?php echo $id?>">图集(<?php echo M('pic')->where("ti=$id")->count(); ?>)</a></td>

        <?php if ($ty==11): ?><td><?=isset($d1[$istop]) ? $d1[$istop] : '','&emsp;',isset($d2[$istop2]) ? $d2[$istop2] : '' ?></td><?php endif ?>
        <!-- <td><?=$hits?></td> -->
        <!-- <a href="pic.php?ti=<?=$id?>&cid=5">户型介绍(<?//=M('pic')->where("ti=$id and cid=5 and isstate=1")->count()?>条)</a> -->
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==10):/*＜＞＜＞产品分类＜＞＜＞*/?>
        <td><?=$img1?><?=$title?></td>
        <td><span class="fl"><a href="goods.php?category_id_1=<?=$ty?>&category_id_2=<?=$id?>">查看该类目下商品(<?php echo M(Good::TABLE)->where("category_id_1=$id")->count(); ?>条)</a>&emsp;<a href="goods_pro.php?category_id_1=<?=$ty?>&category_id_2=<?=$id?>">添加新商品</a></span></td>
<!-- <td><span data-content="<?=$introduce?>" class="lookinfo layui-btn layui-btn-primary layer-demolist">查看简介</span></td> -->
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==11):/*＜＞＜＞图文列表＜＞＜＞*/?>
        <td><?=$img1?></td>
        <td><?=$title,'&emsp;',$ftitle,'&emsp;',$name?><a href="pic.php?ti=<?php echo $id?>">图集(<?php echo M('pic')->where("ti=$id")->count(); ?>)</a>&emsp;&emsp;<a href="link.php?showtype=5&istop=<?php echo $id ?>">历程(<?php echo M('news')->where("istop=$id")->count(); ?>)</a></td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/endif?>
     <td><?=$time?></td>
 </tr>
<?php endforeach?>
<?php include('js/foot'); ?>
<!-- <td><?=$img1?><a class="lookPic" href="javascript:;" data-id="<?=$id?>">添加更多图片(<?=M('pic')->where("ti=$id")->count()?>个)</a></td> -->
