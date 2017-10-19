<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';

$checkid=opturl("checkid");
$action=opturl("action");
$id=$_GET['id'];
$sort=$_GET['sort'];
$key=trim(opturl("key"));
$url=urlencode($_SERVER['QUERY_STRING']);
$indexurl=opturl("indexurl");

$path="../".$upload_picpath."/";

if ($action=="confirm"){
	if (empty($id)){
		JsError("参数提交错误");
	}
	$sql="update `{$tablepre}news` SET isstate=NOT(isstate) WHERE id=".$id;
	$db->sql_query($sql);
	AddLog("审核新闻内容",$_SESSION['Admin_UserName']);
	JsSucce("操作成功！","delete.php");
	exit();
}elseif ($action=="del"){
	$del_num=count($checkid);
	if($_POST['cats']) $pp=explode('|',$_POST['cats']);
	$npid=$pp[0];
	$nty=$pp[1];

	for($i=0;$i<$del_num;$i++){
		$sql="select img1,img2,img3,file FROM `{$tablepre}news` where id=".$checkid[$i]."";
		$result=$db->sql_query($sql);
		if($bd=$db->sql_fetchrow($result)){
			@unlink($path.$bd['img1']);
			@unlink($path.$bd['img2']);
			@unlink($path.$bd['img3']);
			@unlink($path.$bd['file']);
			$db->sql_query("delete FROM `{$tablepre}news` where id=".$checkid[$i]."");
		}
		JsSucce("操作成功！","delete.php".$indexurl);
 	}
	AddLog("删除新闻内容",$_SESSION['Admin_UserName']);
	exit();
}

if ($key) $sqlkey.=" AND binary title like '%".$key."%'";

$pagesize=15;
$page=(int)$_GET['page']==0?1:(int)$_GET['page'];
$sql="select * FROM `{$tablepre}news` where 1=1 {$sqlkey} order by sendtime desc,id desc";
$pagestr=page_list($sql,$page,$pagesize);
$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
$result=$db->sql_query($sql);
//echo $sql;
$PageCount=$db->sql_numrows($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新闻管理页面</title>
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
				<?=$classname?>
            </p>
        </div>
    	<div class="right clr">


            <div class="zhengwen clr">
			<form name="formlist" method="post" action="?action=del">

             	<div class="zhixin clr">
                	<ul class="toolbar">
                        <li>&nbsp;<input type="checkbox" name="all" class="quanxuan" onClick="CheckAll(this);" id="selectAll" > 全选</li>
                    </ul>
                    <input type="submit" class="zhixin_a4 fl" onClick="return checkData();" name="ok" value="" />
                </div>
                <div class="neirong clr">
                	<table cellpadding="0" cellspacing="0" class="table clr">
                        <tr class="first">
							<td width="6%">选择</td>
							<td width="9%">编号</td>
							<td width="10%">一级栏目</td>
							<td width="9%">二级栏目</td>
							<td width="14%">三级栏目</td>
							<td width="24%">标题</td>
							<td width="8%">是否审核</td>
							<td width="6%">预览</td>
							<td width="14%">发布时间</td>
                        </tr>
   <?
	while($bd=$db->sql_fetchrow($result)){
		if(!empty($bd['img1'])) $Img=$bd['img1']; else $Img="nopic.jpg";
		if($bd['isstate']==1)
			$zt="<a href='?action=confirm&id=".$bd['id']."'><font color='red'>已审核</font></a>";
		else
			 $zt="<a href='?action=confirm&id=".$bd['id']."'><font color=''>未审核</font></a>";
	?>
					    <tr>
							<td><input name="checkid[]" type="checkbox" id="checkid[]" value="<?=$bd['id']?>"></td>
							<td><?=$bd['id']?></td>
							<td><?=v_news_cats($bd['pid'],'catname')?></td>
							<td><?=v_news_cats($bd['ty'],'catname')?></td>
							<td><?=v_news_cats($bd['tty'],'catname')?></td>
							<td><?=$bd['title']?></td>
							<td><?=$zt?></td>
							<td><a href="../view.php?action=a&id=<?=$bd['id']?>" target="_blank">预览</a></td>
							<td><?=date('Y-m-d H:i:s',$bd['sendtime'])?></td>
                        </tr>
	<? }?>
                     </table>

					<?=$pagestr;?>

                </div>

                </form>
            </div>

        </div>


 	</div>

</body>
</html>