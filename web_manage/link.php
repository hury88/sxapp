<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = 'news';
$showname = 'link';

/*if (isset($_GET['action']) && $_GET['action']=="filetype"){
  if (empty($id)){
    Redirect::JsError("参数提交错误");
  }
  M('news')->where("id=$id")->setField(array('istop'=>array('exp','NOT(istop)')));
  Redirect::JsError("切换成功");
}*/

//条件
$map = array('pid'=>$pid,'ty'=>$ty,'tty'=>$tty);
//搜索
$$showtype =  I('get.$showtype',0,'intval');if(!empty($$showtype))$map['$showtype'] = $$showtype;
$istop =  I('get.istop',0,'intval');if(!empty($istop))$map['istop'] = $istop;
$istop2 =  I('get.istop2',0,'intval');if(!empty($istop2))$map['istop2'] = $istop2;
{
    // $title   =   I('get.title','','trim');
    // if ($title) $map['title'] = array('like','%'.$title.'%');
}
####分页配置
$psize   =   I('get.psize',30,'intval');
$pageConfig = array(
        'where' => $map,//条件
        'order' => 'sendtime desc',//排序
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
	<?php include('js/head'); ?>

	<link rel="stylesheet" href="/public/dropzone/dropzone.css">
	<script src="/public/dropzone/dropzone.min.js"></script>
</head>

<body>
	<div class="content clr">
    <div class="right clr">
        <?php if ($showtype==-1): ?>


        <!-- div class="col-md-12">
          <h2 class="top_title"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>.jpg,.png,.gif图片上传</h2>
          <div class="row" style="margin-top:30px;">
              <div class="col-md-6 col-xs-12 col-md-offset-3">
                  <form id="mydropzone" action="/target" class="dropzone"></form>
                  <div id="mydropzone" class="dropzone"></div>
              </div>
          </div>
              </div> -->

      <script>
      var myDropzone = new Dropzone("div#mydropzone", {
          url: "include/action.php?a=dropupload&id=<?=$id?>",
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
      <script>
			 /*   $(".pic_del").click(function(){
			        var tthis=$(this);
			        $.get("json.php?action=pic_del&pid=<?=$pid?>&id="+tthis.data("id"),function(data){
			            if(data=="ok"){
			                tthis.parents("tr").remove();
			            }else{
			                alert(data)
			            }
			        })
})*/
</script>

<?php endif ?>
<form name="formlists" id="jsSoForm">
  <tbody>
      <tr>
          <td>
            <b>显示</b><input name="psize" type="text" class="search dfinput" value="<?=$psize?>"/>条
            <input type="hidden" name="pid" value="<?=$pid?>" />
            <input type="hidden" name="ty"  value="<?=$ty?>"  />
            <input type="hidden" name="tty" value="<?=$tty?>" />
            <?php
              // $d = config('webarr.pageType');Output::select2($d,'类型','istop2');
             ?>
            <input name="istop" type="hidden" value="<?php echo $istop ?>"/></td>
            <input name="showtype" type="hidden" value="<?php echo $showtype ?>"/></td>
            <input name="search" type="submit" class="btn" value="搜索"/></td>
        </tr>
    </tbody>
</form>

<div class="zhengwen clr">
    <form name="formlist" method="post" action="include/action.php">

      <div class="zhixin clr">
        <ul class="toolbar">
            <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
        </ul>
        <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a><!-- 刷新  -->
        <a href="<?=getUrl(queryString(true),$showname.'_pro')?>" target="righthtml" class="zhixin_a3 fl"></a><!-- 添加  -->
        <input type="button" class="zhixin_a4 fl" id="del"/><!-- 删除  -->
        <?php if (6 == $pid): ?>
            <a style="background:none;border:1px solid;line-height:28px;text-align:center" href="content.php?<?=queryString()?>" class="fl">编辑详情</a>
        <?php endif ?>
    </div>
    <div class="neirong clr">
       <table cellpadding="0" cellspacing="0" class="table clr">
          <tr class="first">
            <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
            <td width="24px">编号</td> <td width="150px">操作</td>

<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/    if ($showtype==3):/*＜＞＜＞图片列表＜＞＜＞*/?>
            <td> 配图 </td>
            <td> 标题 </td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==4):/*＜＞＜＞友情链接＜＞＜＞*/?>
            <!-- <td width="24px"> 配图 </td> -->
            <td> 名称 </td>
            <td> 跳链 </td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==5):/*＜＞＜＞关联单条信息＜＞＜＞*/?>
            <td> 历程 </td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==6):/*＜＞＜＞轮播图片＜＞＜＞*/?>
            <td width="24px">图片</td>
            <td> 标题 </td>
            <td> 跳链 </td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==8):/*＜＞＜＞文件下载＜＞＜＞*/?>
            <td width="24px">配图</td>
            <td>文件名</td>
            <td>介绍</td>
            <!-- <td>下载次数</td> -->
            <td>类型(<b style="color:red">点击切换</b>)</td>
            <td>下载</td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/endif?>
            <td width="10%">发布时间</td>
        </tr>
        <tbody>
            <!-- #################################################################################################################### -->

            <?php
                foreach ($data as $key => $bd) : extract($bd);
                //生成修改地址
                $query = queryString(true);
                $query['id'] = $id;
                $editUrl = getUrl($query,$showname.'_pro');
                //生成修改地址END
                $time =  date('Y-m-d H:i:s',$sendtime);
                // $title =  '<a href="'.getUrl($id,'../view').'" target="_blank">'.$title.'</a>';
                // $img1 =  '<img src="'.src($img1).'" width="80" />';
                $img1 =  '<img src="'.src($img1).'" width="80" />';
                $img2 =  '<img src="'.src($img2).'" width="80" />';

            ?>
            <tr>
             <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
             <td><?=$id?></td>
             <td>
                <a href="<?=$editUrl?>">编辑</a>|
                <?php if ($ty==26): ?>
                    <a data-class="btn-warm" class="json <?=$istop==1?'btn-warm':'' ?>" data-url="isindex&id=<?=$id?>"><?=config('webarr.isindex')[$istop] ?></a>|
                <?php endif ?>
                <a data-class="btn-danger" class="json <?=$isgood==1?'btn-danger':'' ?>" data-url="isgood&id=<?=$id?>"><?=Config::get('webarr.isgood')[$isgood] ?></a>|
                <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=Config::get('webarr.isstate')[$isstate] ?></a>|
                <!-- <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a> -->
             </td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/   if ($showtype==3):/*＜＞＜＞图片列表＜＞＜＞*/?>
             <td><?=$img1/*,$img2*/?></td>
             <td><?=$title,'<span class="fr">'.$ftitle.'</span>' ?></td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==4):/*＜＞＜＞友情链接＜＞＜＞*/?>
             <!-- <td><?=$img1?></td> -->
             <td><a target="_blank" href="<?=$linkurl?>"><?=$title?></a></td>
             <td><?=$linkurl?></td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==5):/*＜＞＜＞关联单条信息＜＞＜＞*/?>
             <td><?=$title,'&emsp;',$ftitle?></td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==6):/*＜＞＜＞轮播图片＜＞＜＞*/?>
             <td><?php echo $img1 ?></td>
             <td><?=htmlspecialchars_decode($title)?></td>
             <td><?=$linkurl?></td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==8):/*＜＞＜＞文件下载＜＞＜＞*/?>
             <td><?=$img1?></td>
             <td><?=$title?></td>
             <td><a href="pic.php?showtype=8&ti=<?php echo $id?>">细节图(<?php echo M('pic')->where("ti=$id")->count(); ?>)</a><span data-content="<?=$content?>" class="lookinfo layui-btn layui-btn-primary layer-demolist">查看介绍</span></td>
             <!-- <td><?=$hits?></td> -->
             <!-- <td><?=$download?></td> -->
             <td> <a data-class="btn-danger" class="json <?=$istop==1?'btn-danger':'' ?>" data-url="isdownload&id=<?=$id?>"><?=Config::get('webarr.isdownload')[$istop] ?></a></td>

             <td><a download href="<?=$istop ? $linkurl : src($file) ?>">下载</a></td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/endif?>

             <td><?=$time?></td>
        </tr>
    <?php endforeach;?>


<?php include('js/foot'); ?>

             <!-- <td><span data-content="<?=$content?>" class="lookinfo layui-btn layui-btn-primary layer-demolist">查看配文</span></td> -->


