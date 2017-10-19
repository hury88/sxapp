<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';

$action  = I('get.action','');
$id      = I('get.id','');
$table   = 'logs';
$showname= 'log';
if ($action=="del"){
    $checkid = isset($_POST['checkid']) ? $_POST['checkid'] : array();
    if(M($table)->delete($checkid)){
      Redirect::JsSuccess("删除成功！","log.php");
    }else{
      Redirect::JsSuccess("删除失败","log.php");
    }
    exit();
}elseif ($action=="alldel"){
    M()->query('TRUNCATE `'.config('database.prefix').'logs`');
    Redirect::JsSuccess('操作成功！','log.php');
    exit();
}

$map = array();
########################分页配置开始
$psize   =   I('get.psize',30,'intval');
$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => 'sendtime desc',
    /*条数*/'psize' => $psize,
    /*表  */'table' => $table,
    );
list($data,$pagestr) = Page::paging($pageConfig);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>操作日志</title>
    <link href="images/common.css" rel="stylesheet" type="text/css" />
    <link href="images/style.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-1.8.3.min.js" language="javascript"></script>
    <script src="js/js.js" language="javascript"></script>
    <script src="js/checkform.js" language="javascript"></script>
</head>

<body>
	<div class="content clr">
       <div class="weizhi">
        <p>位置：
            <a href="mains.php">首页</a>
            <span>></span>
            <a href="log.php">操作日志</a>
        </p>
    </div>
    <div class="right clr">


        <div class="zhengwen clr">
         <form name="formlist" method="post" action="?action=del">

          <div class="zhixin clr">
           <ul class="toolbar">
               <li>&nbsp;<input type="button" class="quanxuan" onClick="location.href='?action=alldel'" value="清空日志"> </li>
           </ul>
           <ul class="toolbar">
               <li>&nbsp;<input type="checkbox" name="all" class="quanxuan" onClick="CheckAll(this);" id="selectAll" > 全选</li>
           </ul>
           <a href="?<?php echo $url?>" class="zhixin_a2 fl"></a>
           <input type="submit" class="zhixin_a4 fl" onClick="return checkData();" name="ok" value="" />
       </div>
       <div class="neirong clr">
           <table cellpadding="0" cellspacing="0" class="table clr">
            <tr class="first">
             <td width="6%">选择</td>
             <td width="7%">编号</td>
             <td width="15%">用户名</td>
             <td width="47%">操作内容</td>
             <td width="12%">IP</td>
             <td width="13%">操作时间</td>
         </tr>
         <?php foreach ($data as $key => $value) : extract($value); ?>
           <tr>
            <td><input name="checkid[]" type="checkbox" id="checkid[]" value="<?php echo $id?>"></td>
            <td><?php echo $id?></td>
            <td><?php echo $username?></td>
            <td><?php echo htmlspecialchars_decode( $content )?></td>
            <td><?php echo $ip?></td>
            <td><?php echo date('Y-m-d H:i:s',$sendtime)?></td>
        </tr>
        <?php endforeach ?>
    </table>

    <?php echo $pagestr?>

</div>

</form>
</div>

</div>


</div>

</body>
</html>
