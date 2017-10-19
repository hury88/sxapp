<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
$id= I('get.id', 0, 'intval');

if($row=M('news_cats')->where("id=$id")->find()){
    extract($row);
}
if(IS_POST)
{
    $fields=array();
    uppro('img1',$fields);
    uppro('img2',$fields);
    $fields['id'] = $id;
	if( M('news_cats')->update($fields) ) {
		Redirect::JsSuccess("更新数据成功,操作成功！",'ban.php');
	}else{
		Redirect::JsError("更新数据失败,操作失败！");
	}
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <title>新闻1,2,单挑合用页面</title>
    <?php define('IN_PRO',1);include('js/head'); ?>
<body>

	<div class="content clr">
    	<div class="weizhi">
            <p>位置：
                <a href="mains.php">首页</a>
                <span>></span>
                <a href="javascript:void()">栏目管理</a>
                <span>></span>
                <a href="javascript:void()">栏目修改</a>
            </p>
        </div>
    	<div class="right clr">

            <div class="zhengwen clr">
            	<div class="xuanhuan clr">
                	<a href="javascript:void()" class="zai" style="margin-left:30px;"><?=$row['catname']?></a>
                 </div>

                <div class="miaoshu clr">
                    <div id="tab1" class="tabson">
        				<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
                            <ul class="forminfo">
						<form name="form1" method="post" action="" onSubmit="return checkcats(this)" enctype="multipart/form-data">
							<li class="fade"><label>所属栏目<b>*</b></label><?=$row['catname']?></li>
                            <?php printImgHtml('类型一','img1','302X210') ?>
                            <?php // printImgHtml('导航配图','img2','215*150') ?>
                            <input type="hidden" name="id" value="<?=$id?>" />
 							<li class="fade"><label>&nbsp;</label><input type="submit" class="btn" value="提  交"/></li>
							</form>
					   </ul>
      			  	</div>
                </div>

            </div>

        </div>


 	</div>

</body>
</html>
