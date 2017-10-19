<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'pic';
$showname = 'pic';
$ti = I('get.ti',0,'intval');
//条件
$map = array('ti'=>$ti);
####分页配置
$psize   =   I('get.psize',100,'intval');
$pageConfig = array(
        'where' => $map,//条件
        'order' => 'id desc',//排序
        'psize' => $psize,//条数
        'table' => $table,//表
        );
list($data,$pagestr) = Page::paging($pageConfig);
####
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>图片</title>
	<?php include('js/head'); ?>

	<link rel="stylesheet" href="/public/dropzone/dropzone.css">
	<script src="/public/dropzone/dropzone.min.js"></script>
</head>

<body>
	<div class="content clr">
    <div class="right clr">
      <div class="col-md-12">
        <h2 class="top_title"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>.jpg,.png,.gif图片上传</h2>
        <div class="row" style="margin-top:30px;">
          <div class="col-md-6 col-xs-12 col-md-offset-3">
            <!--<form id="mydropzone" action="/target" class="dropzone"></form>-->
            <div id="mydropzone" class="dropzone"></div>
          </div>
        </div>
      </div>
      <script>
      var myDropzone = new Dropzone("div#mydropzone", {
        url: "include/action.php?a=dropupload&id=<?=$ti?> ?>",
        paramName: "img1",
    		        maxFilesize: 2, // MB
    		        maxFiles: 20,
    		        acceptedFiles: ".jpg,.png,.gif",
    		     /*   success: function(file, data) {
    		                    console.log(file + "," + data);
    		        },
    		        init: function(file) {
    		            console.log(file);
                  }*/
                });
      </script>

      <div class="zhengwen">
       <div class="zhixin clr">
         <ul class="toolbar">
           <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
         </ul>
         <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a><!-- 刷新  -->
         <a href="<?=getUrl(queryString(true),$showname.'_pro')?>" target="righthtml" class="zhixin_a3 fl"></a><!-- 添加  -->
         <input id="del" type="button" class="zhixin_a4 fl"/><!-- 删除  -->
       </div>
       <form name="formlist" method="post" action="include/action.php">
        <div class="neirong clr">
         <table cellpadding="0" cellspacing="0" class="table clr">
          <tr class="first">
            <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
            <td width="24px">编号</td><td width="100px">操作</td>
            <td> 配图 </td>
            <!-- <td> 标题 </td> -->
          </tr>
          <tbody>
           <?php
            foreach ($data as $key => $bd) :
                extract($bd);
                #生成修改地址
                $query = queryString(true,false);
                $query['id'] = $id;
                $editUrl = getUrl($query,$showname.'_pro');

                $img1 =  '<img src="'.src($img1).'" width="80" />';
                // $img2 =  '<img src="'.src($img2).'" width="80" />';
                $img2 =  '';
          ?>
          <tr>
           <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
           <td><?=$key+1?></td>
           <td>
             <a href="<?=$editUrl?>" class="thick ">编辑</a>|
             <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
           </td>
           <td><?=$img1,$img2?> </td>
           <!-- <td><?=$title?> </td> -->
         </tr>

       <?php endforeach;include('js/foot'); ?>

