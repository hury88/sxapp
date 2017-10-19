<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = $showname = 'goods';
$category_id_1 = I('get.category_id_1', 0, 'intval');
$category_id_2 = I('get.category_id_2', 0, 'intval');

//条件
$map = array();
###########################筛选开始
$id    =   I('get.id','','trim');if(!empty($id))$map['id'] = array('like',"%$id%");
$category_id_1 = I('get.category_id_1','','trim');if(!empty($category_id_1))$map['category_id_1'] = $category_id_1;
$category_id_2 = I('get.category_id_2','','trim');if(!empty($category_id_2))$map['category_id_2'] = $category_id_2;
$title =   I('get.title','','trim');if(!empty($title))$map['title'] = array('like',"%$title%");
###########################筛选开始
########################分页配置开始
$psize   =   I('get.psize',30,'intval');
$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => 'disorder desc,id asc',
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
        <?php $classname = ($category_id_1 ? v_news_cats($category_id_1, 'catname') :'') .'<span>></span>' . ($category_id_2 ? v_id($category_id_2, 'title') : '');Style::weizhi() ?>
        <div class="right clr">
          <form class="" id="jsSoForm">
            <input type="hidden" name="category_id_1" value="<?=$category_id_1?>" />
            <input type="hidden" name="category_id_2"  value="<?=$category_id_2?>"  />
            <b>显示</b><input style="width:50px;" name="psize" type="text" class="dfinput" value="<?=$psize?>"/>条
            <!-- <b>编号</b><input name="id" type="text" class="dfinput" value="<?=$id?>"/> -->
            <?php
                $d2 = M('news_cats')->where('pid=1')->order('disorder desc, id asc')->getField('id,catname');Output::select2($d2,'类目一','category_id_1');
                if ($category_id_1) {
                    $d2 = M('news')->where('ty='.$category_id_1)->order('isgood desc, disorder desc, id asc')->getField('id,title');Output::select2($d2,'类目二','category_id_2');
                }
             ?>
            商品名称<input name="title" type="text" class="dfinput" value="<?=$title?>"/>
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

        <td width="45px"> 分类 </td>
        <td width="24px"> 图 </td>
        <td> 商品名称&emsp;补充&emsp;规格 </td>
        <td> 销量 </td>
        <td> 库存 </td>
    <td width="135px">时间</td>
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
    $category_name_1 = v_news_cats($category_id_1, 'catname');
    $category_name_2 = v_id($category_id_2, 'title');

    // $title = '<a href="' . U('blog/view', ['id'=>$id]) . '" target="_blank">'.$title.'</a>';
?>
<tbody>
    <tr>
        <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
        <td><?=$id?></td>
        <td>
            <a href="<?=$editUrl?>" class="thick ">编辑</a>|
            <a data-class="btn-danger" class="json <?=$is_hot==1?'btn-danger':'' ?>" data-url="is_hot&id=<?=$id?>"><?=Config::get('webarr.is_hot')[$is_hot] ?></a>|
            <a data-class="btn-danger" class="json <?=$is_recommend==1?'btn-danger':'' ?>" data-url="is_recommend&id=<?=$id?>"><?=Config::get('webarr.is_recommend')[$is_recommend] ?></a>|
            <a data-class="btn-danger" class="json <?=$is_new==1?'btn-danger':'' ?>" data-url="is_new&id=<?=$id?>"><?=Config::get('webarr.is_new')[$is_new] ?></a>|
            <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=Config::get('webarr.isstate')[$isstate] ?></a>|
            <!-- <a href="<?=$editUrl?>" class="thick edits">编辑</a>| -->
            <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
        </td>
        <td><?=$category_name_1,'&emsp;',$category_name_2?></td>
        <td><?=$img1?></td>
        <td><?=$goods_name,'&emsp;',$goods_name_added,'&emsp;',$size?></td>
        <td><?=$sales?></td>
        <td><?=$stock?></td>
        <td><?='修改-',$time,'<br>发布-',substr($update_time,0,-3)?></td>
 </tr>
<?php
    endforeach;
    define('DEL_TIME_SORT',1);
    include('js/foot');
 ?>
