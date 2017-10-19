<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';

$table = 'manager';
$showname = 'manager';

$id= I('id',0,'intval');
if ($id) { //显示页面 点击修改  只传了id
	$row = M($table)->find($id);
	extract($row);
}

$redirect = getUrl(queryString(true),$showname);
if (IS_POST) { //增加

	$oldpwd=I('post.oldpwd','0','md5');
	$newpwd=I('post.password','','md5');
	$typeid=I('post.typeid',0,'intval');

	if($typeid==2) {
		$bigmymenu   = 'super';
		$smallmymenu = 'super';
	}else {
		$smallmymenu = implode(',',$_POST['smallmymenu']);
	}


	if ($typeid==1){
		$dataTmp = M('news_cats')->where("isstate=1 AND id in ($smallmymenu)")->group('pid')->getField('pid',true);
		$bigmymenu = implode(',',$dataTmp);
	}

	$fields = array(
		'bigmymenu'   	=> 	$bigmymenu,
		'smallmymenu' 	=> 	$smallmymenu,
		'realname' 		=> 	I('post.realname','0','trim'),
		'username' 		=> 	I('post.username','0','trim'),
	);
	if($oldpwd<>$newpwd and $newpwd<>"d41d8cd98f00b204e9800998ecf8427e") $fields['password']=$newpwd;


	if (empty($id)) {
		// ECHO '执行插入';
		//检查用户名的唯一性
		if(M($table)->where("`username`='{$fields['username']}'")->getField('id')){
			JsError("对不起该用户名 ".$fields['username']." 已有人使用，请重新输入！");
			exit();
		}
		$fields['sendtime']	=	$PHP_TIME;
		$fields['isstate']	=	1;
		if( M($table)->insert($fields) ) {

			AddLog("添加{$showname}_pro管理员信息",$_SESSION['Admin_UserName']);
			JsSucce("添加数据成功,操作成功！",$redirect);
		}else{
			// _sql();exit;
			JsError("添加数据失败,请至少选择一个有效分类！");
		}
	}else{
		// ECHO '执行更新';
		$fields['id'] = $id;
		if( M($table)->update($fields) ) {
			AddLog("编辑{$showname}_pro管理员信息",$_SESSION['Admin_UserName']);
			JsSucce("更新数据成功,操作成功！",$redirect);
		}else{
			JsError("更新数据失败,操作失败！");
		}
	}
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>管理员编辑页面</title>
	<link href="images/common.css" rel="stylesheet" type="text/css" />
	<link href="images/style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-1.8.3.min.js" language="javascript"></script>
	<script src="js/js.js" language="javascript"></script>
	<script src="js/placeholdem.min.js"></script>
	<script language="javascript" src="js/checkform.js"></script>
</head>

<div class="content clr">
	<div class="weizhi">
		<p>位置：
			<a href="mains.php">首页</a>
			<span>></span>
			<a href="manager.php">管理员信息</a>
			<span>></span>
			<a href="javascript:void()">信息修改</a>
		</p>
	</div>
	<div class="right clr">


		<div class="zhengwen clr">
			<div class="xuanhuan clr">
				<a href="javascript:void()" class="zai" style="margin-left:30px;">管理员</a>
			</div>

			<div class="miaoshu clr">
				<div id="tab1" class="tabson">
					<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
					<ul class="forminfo">
						<!-- <form name="formlist" method="post" action="" onSubmit="return checkmanager_add(this);"> -->
						<form name="formlist" method="post" action="" onSubmit="">
							<input type="hidden" name="id" value="<?=$id?>">
							<?php printInputHtml('管理姓名','realname') ?>
							<?php printInputHtml('管理帐号','username') ?>
							<li class="fade"><label>登陆密码<b>*</b></label><input name="password" type="password" class="shurukuang" value=""/>  (不修改则为空)</li>
							<li class="fade"><label>确认密码<b>*</b></label><input name="password1" type="password" class="shurukuang" value=""/></li>
							<li class="fade"><label>管理员类型<b>*</b></label><input name="typeid" type="radio" onClick="show(0)" value="2" <? if(isset($bigmymenu)&&$bigmymenu=="super") echo 'checked'?>> 超级管理员 <input type="radio" name="typeid" value="1" onClick="show(2)" <? if(isset($bigmymenu)&&$bigmymenu<>"super") echo 'checked'?>> 普通管理员</li>
							<li id="dlqy" style="display:none"><label>管理员权限<b>*</b></label>
								<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolorlight="#A1BC7A" bordercolordark="#FFFFFF">
									<?
									// $sql="SELECT id,catname FROM `{$tablepre}news_cats` WHERE isstate=1 AND pid=0  ORDER BY disorder ASC,id ASC";
									$data1ji = M('news_cats')->field('id,catname')->where('isstate=1 AND pid=0')->order('disorder ASC,id ASC')->select();
									foreach ($data1ji as $key1ji => $row) {
										$pid = $row['id'];
										?>
										<tr bgcolor="#FFFFFF">
											<td width=2% height="25" align="center"></td>
											<td width=98% height="25">
												<b><?=$row['id']?>:<?=$row['catname']?></b><br>
												<?
												$data2ji = M('news_cats')->field('id,catname')->where("isstate=1 AND pid=$pid")->order('disorder ASC,id ASC')->select();
												$smallmymenu = isset($smallmymenu)?$smallmymenu:'';
												foreach ($data2ji as $key2 => $row2) {

													$AdvQx=explode(',',$smallmymenu);
													$ck="";
													foreach($AdvQx as $mn)
														if(trim($mn)==$row2['id']) $ck="checked";

													if($key2%5==0)$bj="<br>"; else $bj="";
													?>
													<?=$bj?><input name="smallmymenu[]" type="checkbox" id="smallmymenu[]" value="<?=$row2['id']?>"  <?=$ck?>>
													<?=$row2['catname']?>&nbsp;&nbsp;
													<? }//二级结束 ?><br>
												</td>
											</tr>

											<?
										}//循环一级结束
										?>
										<tr>
											<td></td>
											<td>
												<input name="smallmymenu[]" type="checkbox" id="smallmymenu[]" value="-1" <?php if (in_array(-1, $AdvQx)): ?>checked <?php endif ?>>追踪编号<?php //-1代表有修改编号的权利 ?>
												<input name="smallmymenu[]" type="checkbox" id="smallmymenu[]" value="-2" <?php if (in_array(-2, $AdvQx)): ?>checked <?php endif ?>>修改<?php //-2代表有修改权限 ?>
											</td>
										</tr>
									</table>
								</li>
								<li class="fade"><label>&nbsp;</label><input name="update" type="submit" class="btn" value="提  交"/></li>
							</form>
						</ul>
					</div>
				</div>

			</div>

		</div>


	</div>

</body>
</html>