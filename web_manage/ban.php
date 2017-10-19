<?php
require 'include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'news_cats';
$showname = 'ban';

$id    =   I('get.id', 0,'intval');
$pid   =   I('get.pid',0,'intval');
$ty    =   I('get.ty', 0,'intval');
$tty   =   I('get.tty',0,'intval');

/*$classname='<a href="javascript:void()">'.get_catname($pid,'news_cats').'</a> <span>></span> <a href="javascript:void()">'.get_catname($ty,"news_cats").'</a>';
$zid=$ty;
if($tty){
	$zid=$tty;
	$classname .= '<span>></span> <a href="javascript:void()">'.get_catname($tty,"news_cats").'</a>';
}
if(isset($_GET['showtype'])){//主动传值优先级最大
	$showtype = (int)$_GET['showtype'];
}else{
	$showtype=get_catname($zid,"news_cats","showtype");
}*/

//条件
$map = array('pid'=>1,'catname'=>array('neq','辅助栏目'),'isstate'=>1);

########################分页配置开始
    $psize   =   I('get.psize',30,'intval');
    $pageConfig = array(
        /*条件*/'where' => $map,
        /*排序*/'order' => 'disorder desc, id ASC',
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
	<title>图文合用页面</title>
	<?php include('js/head'); ?>
</head>

<body>
	<div class="content clr">
    	<div class="weizhi">
            <p>位置：
                <a href="mains.php">首页</a>
                <span>></span>
				内页banner
				<span><a href="javascript:history.back()">返回</a></span>
            </p>
        </div>
    	<div class="right clr">
            <div class="zhengwen clr">
                <div class="neirong clr">
                    <table cellpadding="0" cellspacing="0" class="table clr">
                           <tr class="first">
                            <td width="24px">编号</td>
                            <td> 名称 </td>
                            <td> BANNER </td>
                            <td width="150px">操作</td>
                         </tr>
<!-- #################################################################################################################### -->

   <?php
    foreach ($data as $key => $bd) :

        @extract($bd);
/*
        if (in_array($id, [2])) {
            continue;
        }*/

        {//生成修改地址
            $query = queryString(true);
            $query['id'] = $id;
            $editUrl = getUrl($query,$showname.'_pro');
        }
        //时间
    ?>
                     <tbody>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$catname?></td>
                            <td> <img src="<?=src($img1)?>" width="80" /> <!-- 列表图 : <img src="<?=src($img2)?>" width="80" />  --></td>
<!-- #################################################################################################################### -->
                            <td>
                                <a href="<?=$editUrl?>" class="thick ">编辑</a>|
                                <!-- <a data-class="btn-danger" class="json <?=$isgood==1?'btn-danger':'' ?>" data-url="isgood&id=<?=$id?>"><?=Config::get('webarr.isgood')[$isgood] ?></a>| -->
                                <!-- <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=Config::get('webarr.isstate')[$isstate] ?></a>| -->
                            </td>
                        </tr>
<?php endforeach?></tbody></table> </div> </div> </div> </div> </body> </html> <?php include('js/foot'); ?>