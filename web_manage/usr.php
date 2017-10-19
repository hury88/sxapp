<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
$table = $showname = 'usr';

//条件
$map = array();

###########################筛选开始
$id       =   I('get.id','','trim');if(!empty($id))$map['id'] = array('like',"%$id%");
$phone    =   I('get.phone','','trim');if(!empty($phone))$map['phone'] = array('like',"%$phone%");
$email    =   I('get.email','','trim');if(!empty($email))$map['email'] = array('like',"%$email%");
###########################筛选开始

########################分页配置开始
$psize   =   I('get.psize',30,'intval');
$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => 'lastlogintime desc',
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
    <title>用户页面</title>
    <?php include('js/head'); ?>
</head>
<body>
    <div class="content clr">
        <div class="right clr">
              <form class="" id="jsSoForm">
                <b>显示</b><input style="width:50px;" name="psize" type="text" class="dfinput" value="<?=$psize?>"/>条
                <b>编号</b><input name="id" type="text" class="dfinput" value="<?=$id?>"/>
                <b>手机号</b><input name="phone" type="text" class="dfinput" value="<?=$phone?>"/>
                <b>邮箱</b><input name="email" type="text" class="dfinput" value="<?=$email?>"/>
                <input name="search" type="submit" class="btn" value="搜索"/></td>

            </form>
        <?=$pagestr?>
            <div class="zhengwen">
                 <div class="zhixin clr">
                   <ul class="toolbar">
                       <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
                   </ul>
                   <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a><!-- 刷新  -->
                   <!-- <a href="<?=getUrl(queryString(true),$showname.'_pro')?>" target="righthtml" class="zhixin_a3 fl"></a>-->
                   <input id="del" type="button" class="zhixin_a4 fl"/><!-- 删除  -->
                   <?php Style::moveback() ?>
            </div>
            <div class="neirong clr">
                <table cellpadding="0" cellspacing="0" class="table clr">
                 <tr class="first">
                    <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
                    <td width="24px">编号</td> <td width="150px">操作</td>

                    <td>头像</td>
                    <td>手机号</td>
                    <td>昵称</td>
                    <td>性别</td>
                    <td>最后登录 - ip</td>
                    <td>注册时间</td>

                </tr>
                <?php
                    foreach ($data as $key => $bd) : extract($bd);

                    #生成修改地址
                    $query = queryString(true);
                    $query['id'] = $id;
                    $editUrl = getUrl($query, $showname.'_pro');
                ?>
        <tbody>
            <tr>
                <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
                <td><?=$id?></td>
                <td>
                    <a href="<?=$editUrl?>" class="thick ">编辑</a>|
                    <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>|
                    <!-- <a href="order.php?usrid=<?php echo $id ?>">订单(<?php //echo M(Order::TABLE)->where("usrid=$id")->count() ?>)</a> -->
                </td>
                <td><img src="<?=src($headimg, 'headImage', 'headImageDefault')?>"></td>
                <td><?=$mobile?></td>
                <td><?=$nickname?></td>
                <td><?=$gender==1?'男':$gender==2?'女':'未知'?></td>
                <td><?=date('Y-m-d', $lastlogintime)?> - <?php echo $lastloginip ?></td>
                <td><?=date('Y-m-d', $regtime)?></td>
            </tr>
        <?php endforeach?>
        <?php include('js/foot'); ?>

