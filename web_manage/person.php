<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
$table  = 'manager';
$showname  = 'person';
if(isset($_POST['update'])){
	$newpwd=I('post.pwd_new','','md5');//md5($_POST['pwd_new']);
	$oldpwd=I('post.pwd_old','','md5');//md5($_POST['pwd_old']);

	$map = array(
		'username' => $_SESSION['Admin_UserName'],
		'password' => $oldpwd,
	);
	$result = M($table)->where($map)->find();
	if(!$result){
		Redirect::JsError("信息提示:原密码错误!");
	}else{
		$result = M($table)->where($map)->setField('password',$newpwd);
		AddLog("编辑普通管理员密码",$_SESSION['Admin_UserName']);
		Redirect::JsSuccess("操作成功！","person.php");
	}
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>密码修改</title>
<link href="images/common.css" rel="stylesheet" type="text/css" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.8.3.min.js" language="javascript"></script>
<script src="js/js.js" language="javascript"></script>
<script src="js/placeholdem.min.js"></script>

<script language="javascript" src="js/checkform.js"></script>
</head>

<body>

	<div class="content clr">
    	<div class="weizhi">
            <p>位置：
                <a href="mains.php">首页</a>
                <span>></span>
                <a href="person.php">密码修改</a>
            </p>
        </div>
    	<div class="right clr">


            <div class="zhengwen clr">
            	<div class="xuanhuan clr">
                	<a href="javascript:void()" class="zai" style="margin-left:30px;">密码修改</a>
                 </div>

                <div class="miaoshu clr">
                    <div id="tab1" class="tabson">
        				<div class="formtext">Hi，<b><?php echo $_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
                            <ul class="forminfo">
							<form name="frm" method="post" action="" onSubmit="return checkperson(this);">
 							<li class="fade"><label>原密码<b>*</b></label><input name="pwd_old" type="text" class="shurukuang" value=""/></li>
 							<li class="fade"><label>新密码<b>*</b></label><input name="pwd_new" type="text" class="shurukuang" value=""/></li>
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