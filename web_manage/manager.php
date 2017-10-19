<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';

$action  = I('get.action','');
$id 	 = I('get.id','');
$table   = 'manager';
$showname= 'manager';

if ($action=="confirm"){
	if (empty($id)){
		JsError("参数提交错误");
	}
	$sql="update `{$tablepre}manager` SET isstate=NOT(isstate) WHERE id=".$id;
	$db->sql_query($sql);

	AddLog("审核管理员帐号",$_SESSION['Admin_UserName']);

	JsSucce("操作成功！","manager.php");
	exit();
}elseif ($action=="del"){
	$checkid = isset($_POST['checkid']) ? $_POST['checkid'] : array();
	if(M($table)->delete($checkid)){
		JsSucce("删除操作成功！","manager.php");
	}else{
		JsSucce("删除操作失败","manager.php");
	}
	AddLog("删除管理员帐号",$_SESSION['Admin_UserName']);
	exit();
}
########################分页配置开始
$pageConfig = array(
	/*条件*/'where' => array(),
	/*排序*/'order' => 'id ASC',
	/*条数*/'psize' => 999,
	/*表  */'table' => $table,
	);
list($data,$pagestr) = Page::paging($pageConfig);
########################分页配置结束
/*$pagesize=15;
$page=(int)$_GET['page']==0?1:(int)$_GET['page'];

$sql="SELECT * FROM `{$tablepre}manager` ORDER BY id ASC";
$pagestr=page_list($sql,$page,$pagesize);
$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
$result=$db->sql_query($sql);
//echo $sql;
$PageCount=$db->sql_numrows($result);*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>管理员管理页面</title>
	<?php include('js/head'); ?>
</head>

<body>
	<div class="content clr">
		<div class="weizhi">
			<p>位置：
				<a href="mains.php">首页</a>
				<span>></span>
				<a href="manager.php">管理员信息</a>
				<span>></span>
				<a href="javascript:void()">信息管理</a>
			</p>
		</div>
		<div class="right clr">


			<div class="zhengwen clr">
				<form name="formlist" method="post" action="manager.php?action=del">

					<div class="zhixin clr">
						<ul class="toolbar">
							<li>&nbsp;<input type="checkbox" name="all" class="quanxuan" onClick="CheckAll(this);" id="selectAll" > 全选</li>
						</ul>
						<a href="?" class="zhixin_a2 fl"></a>
						<a href="<?php echo $showname?>_pro.php" target="righthtml" class="zhixin_a3 fl"></a>
						<input type="submit" class="zhixin_a4 fl" onClick="return checkData();" name="ok" value="" />
					</div>
					<div class="neirong clr">
						<table cellpadding="0" cellspacing="0" class="table clr">
							<tr class="first">
								<td width="5%">选择</td>
								<td width="8%">编号</td>
								<td width="29%">维护人员帐号</td>
								<td width="14%">维护人员姓名</td>
								<td width="11%">维护人员类型</td>
								<td width="8%">是否审核</td>
								<td width="16%">发布时间</td>
								<td width="9%">操作</td>
							</tr>
							<?php foreach ($data as $key => $row) : extract($row);$time = date('Y-m-d H:i:s',$sendtime); 	?>
							<tr>
								<td><input name="checkid[]" type="checkbox" id="checkid[]" value="<?php echo $id?>"></td>
								<td><?php echo $id?></td>
								<td><?php echo $realname?></td>
								<td><?php echo $username?></td>
								<td><?php if ($bigmymenu=="super") echo"超级管理员"; else echo"普通管理员";?></td>
								<td>
									<a data-class="btn-warm" class="json <?php echo $isstate==1?'':'btn-warm' ?>" data-url="s=1&a=isstate&t=<?php echo $table?>&id=<?php echo $id?>"><?php echo Config::get('webarr.isstate')[$isstate] ?></a>
								</td>
								<td><?php echo $time?></td>
								<td><a href="<?php echo $showname?>_pro.php?id=<?php echo $bd['id']?>" class="tablelink">修改</a></td>
							</tr>
						<?php endforeach; $pagestr=''?>
<?php include('js/foot'); ?>