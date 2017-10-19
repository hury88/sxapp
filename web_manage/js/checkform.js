//检测是否是框架,如果不是则返回
function check_frame(url){
	if (top.location==self.location)
	{
		top.location.href=url;
	}
}

check_frame("admin.php");

var tID=0;
function ShowTabs(ID){
	var tTabTitle=document.getElementById("TabTitle"+tID);
	var tTabs=document.getElementById("Tabs"+tID);
	var TabTitle=document.getElementById("TabTitle"+ID);
	var Tabs=document.getElementById("Tabs"+ID);
	if(ID!=tID)
	{
		tTabTitle.className='title1';
		TabTitle.className='title2';
		tTabs.style.display='none';
		Tabs.style.display='';
		tID=ID;
	}
}

function showtr(seltag){
	if(seltag=="1"){
		$('#clzshow').show();
		//$('#cwcshow').hide();
	}else if(seltag=="2"){
		//$('#clzshow').hide();
		$('#cwcshow').show();
	}
 }


function CheckAll(formlist){
  var val=document.formlist.all.checked;
  for (var i=0;i<document.formlist.elements.length;i++){
    var e = document.formlist.elements[i];
    if (e.name != 'all')
      e.checked = val;
  }
}

function checkData (formlist){
  var RecordsCount=0;
  for (var i=0;i<document.formlist.elements.length;i++){
                var e = document.formlist.elements[i];
                if (e.name != 'all' && e.checked)
                       RecordsCount++;
  }

  if(!RecordsCount){
      alert("你还没选择记录！");
      return false
  }else {
     if (confirm("即将操作所有选择的记录， 是否继续 ？")){
     	return true;
	 }else{
         return false;
	 }
   }
}

//选来源效果
function Selectsource(addTitle) {
	var revisedTitle;
	revisedTitle = addTitle;
	document.formlist.source.value=revisedTitle;
	document.formlist.source.focus();
	return;
}
//选作者效果
function Selectauthor(addTitle){
	var revisedTitle;
	revisedTitle = addTitle;
	document.formlist.author.value=revisedTitle;
	document.formlist.author.focus();
	return;
}



function show(val){
	if(val==2){
		document.getElementById("dlqy").style.display = "block";
	}else{
		document.getElementById("dlqy").style.display = "none";
	}

	if(val==1){
		document.getElementById("gsmc").style.display = "block";
		document.getElementById("ywfw").style.display = "block";
	}else{
		document.getElementById("gsmc").style.display = "none";
		document.getElementById("ywfw").style.display = "none";
	}

}


function changeselect1(locationid){
	document.formlist.ty.length = 0;
	document.formlist.ty.options[0] = new Option('-请选择-','');
	for (i=0; i<subcat.length; i++){
		if (subcat[i][0] == locationid){
			document.formlist.ty.options[document.formlist.ty.length] = new Option(subcat[i][1], subcat[i][2]);
		}
	}
}

function changeselect2(locationid2){
	document.formlist.tty.length = 0;
	document.formlist.tty.options[0] = new Option('-请选择-','');
	for (n=0; n<subcat2.length; n++){
		if (subcat2[n][0] == locationid2){
			document.formlist.tty.options[document.formlist.tty.length] = new Option(subcat2[n][1], subcat2[n][2]);
		}
	}
}

function changeselect3(locationid){
	document.formlist.cityid.length = 0;
	document.formlist.cityid.options[0] = new Option('-请选择-','');
	for (i=0; i<subcat.length; i++){
		if (subcat[i][0] == locationid){
			document.formlist.cityid.options[document.formlist.cityid.length] = new Option(subcat[i][1], subcat[i][2]);
		}
	}
}

function changeselect4(locationid2){
	document.formlist.countyid.length = 0;
	document.formlist.countyid.options[0] = new Option('-请选择-','');
	for (n=0; n<subcat2.length; n++){
		if (subcat2[n][0] == locationid2){
			document.formlist.countyid.options[document.formlist.countyid.length] = new Option(subcat2[n][1], subcat2[n][2]);
		}
	}
}

function changecats(locationid){
	document.formlist.ty.length = 0;
	document.formlist.ty.options[0] = new Option('-请选择-','');
	for (i=0; i<subcat3.length; i++){
		if (subcat3[i][0] == locationid){
			document.formlist.ty.options[document.formlist.ty.length] = new Option(subcat3[i][1], subcat3[i][2]);
		}
	}
}


//去空格
function checkspace(checkstr) {
	var str = '';
	for(i = 0; i < checkstr.length; i++)
	{
		str = str + ' ';
	}
	return (str == checkstr);
}

function checkform(obj){
	if(checkspace(obj.username.value)){
		alert("请输入登录用户名!");
		obj.username.focus();
		return false;
	}
	if(checkspace(obj.password.value)){
		alert("请输入登录密码!");
		obj.password.focus();
		return false;
	}
	if(checkspace(obj.door.value)){
		alert("请输入验证码!");
		obj.door.focus();
		return false;
	}
}

function checkform(){
	var content = document.forms[0].item("content");
	if(checkspace(content.value)){
		  alert('留言内容是必填!');
		  return false;
	}


	var ansercontent = document.forms[0].item("ansercontent");
	if(checkspace(ansercontent.value)){
		  alert('回复内容是必填!');
		  return false;
	}
	return true;
}

 //友情链接add/edit JS验证
function check_link(formlist){
	if (checkspace(formlist.title.value)){
		alert("请输入链接名称！");
		formlist.title.focus();
		return false;
	}

	if (checkspace(formlist.linkurl.value)||formlist.linkurl.value=="http://"){
		alert("请输入链接地址！");
		formlist.linkurl.focus();
		return false;
	}
}

 //在线客服add/edit JS验证
function check_qq(formlist){
	if (checkspace(formlist.title.value)){
		alert("请输入客服名称！");
		formlist.title.focus();
		return false;
	}

	if (checkspace(formlist.ftitle.value)){
		alert("请输入QQ！");
		formlist.ftitle.focus();
		return false;
	}
}

 //文件下载add/edit JS验证
function check_file(formlist){
	if (checkspace(formlist.title.value)){
		alert("请输入文件名称！");
		formlist.title.focus();
		return false;
	}

}
 //广告位add/edit JS验证
function check_ad(formlist){
/*	if (checkspace(formlist.title.value))
	{alert("请输入名称！");
	formlist.title.focus();
	return false;
	}*/

	//if (checkspace(formlist.linkurl.value)||formlist.linkurl.value=="http://")
	//{alert("请输入链接地址！");
	//formlist.linkurl.focus();
	//return false;
	//}
}

//验证分类
function checkcats(formlist){
	if (checkspace(formlist.catname.value))
	{alert("请输入类别名称！");
	formlist.catname.focus();
	return false;
	}
}



//删除信息验证
function ConfirmDelInfo()
{
   if(confirm("确定要删除此信息吗？删除后不能恢复！"))
     return true;
   else
     return false;

}



//删除一级分类验证
function ConfirmDelBig()
{
   if(confirm("确定要删除此一级分类吗？删除后不可恢复，请慎重操作！\n\n若分类名称有误，可点击修改按钮修改分类名字即可！\n"))
     return true;
   else
     return false;
}

//删除二级分类验证
function ConfirmDelSmall()
{
   if(confirm("确定要删除此二级分类吗？删除后不可恢复，请慎重操作！\n\n若分类名称有误，可点击修改按钮修改分类名字即可！\n"))
     return true;
   else
     return false;

}

//删除三级分类验证
function ConfirmDelSmall1()
{
   if(confirm("确定要删除此三级分类吗？删除后不可恢复，请慎重操作！\n\n若分类名称有误，可点击修改按钮修改分类名字即可！\n"))
     return true;
   else
     return false;

}

//广告位下拉效果
function selectad(addTitle){
	var revisedTitle;
	revisedTitle = addTitle;
	var revisedTitle1 = addTitle.split('|');
	document.formlist.adname.value=revisedTitle1[0];
	document.formlist.width.value=revisedTitle1[1];
	document.formlist.height.value=revisedTitle1[2];
	document.formlist.pid.value=revisedTitle1[3];
	document.formlist.ty.value=revisedTitle1[4];
	return;
}


 //密码修改页 JS验证
function checkperson(formlist){
  if (checkspace(formlist.pwd_old.value))
  {
    alert("原密码不能为空！");
    formlist.pwd_old.focus();
    return false;
  }
  if (checkspace(formlist.pwd_new.value))
  {
    alert("新密码不能为空！");
    formlist.pwd_new.focus();
    return false;
  }
  if (formlist.pwd_new1.value!=formlist.pwd_new1.value)
  {
    alert("二次密码不一样！");
    document.frm.pwd_new1.focus();
    return false;
  }
}

function SelectAd(addTitle)
{
	var revisedTitle;
	revisedTitle = addTitle;
	var revisedTitle1 = addTitle.split('|');
	document.form1.remark.value=revisedTitle1[0];
	document.form1.width.value=revisedTitle1[1];
	document.form1.height.value=revisedTitle1[2];
	document.form1.pid.value=revisedTitle1[3];
	document.form1.ty.value=revisedTitle1[4];
	return;
}


 //分类add/edit JS验证
function checkcats(formlist)
{
  if (checkspace(formlist.catname.value))
  {
    alert("分类名称不能为空！");
    formlist.catname.focus();
    return false;
  }
}


 //单页面add/edit JS验证
function contents_check(formlist){
  	if(eWebEditor1.getHTML()==""){
	alert("内容不能为空!");
	return false;
	}
}

 //新闻页add/edit JS验证
function news_check(formlist){

 	if (checkspace(formlist.title.value))
	{alert("请输入标题！");
	formlist.title.focus();
	return false;
	}
}

 //影片页add/edit JS验证
function movie_check(formlist){

 	if (checkspace(formlist.title.value)){
		alert("请输入影片名称！");
		formlist.title.focus();
		return false;
	}

 	if (checkspace(formlist.pid.value)||formlist.pid.value==0){
		alert("请选择影片分类！");
		formlist.pid.focus();
		return false;
	}

 	if (checkspace(formlist.content.value)){
		alert("请输入影片介绍！");
		//formlist.content.focus();
		return false;
	}
 }



function uselinkurljs(obj){
   if(obj.uselinkurl.checked==true){
      obj.linkurl.disabled=false;
      article.style.display='none';
   } else {
      obj.linkurl.disabled=true;
      article.style.display='';
   }
}

 //管理员添加页add/edit JS验证
function checkmanager_add(formlist){
  if (checkspace(formlist.username.value))
  {
    alert("请输入管理帐号！");
    formlist.username.focus();
    return false;
  }
  if (checkspace(formlist.password.value))
  {
    alert("请输入登陆密码！");
    formlist.password.focus();
    return false;
  }

  if (formlist.password.value!=formlist.password1.value)
  {
    alert("请保证两次密码一致！");
    formlist.password1.focus();
    return false;
  }
  var qx=0;

 	for (var i=0;i<document.formlist.elements.length;i++)
	{
		var e = document.formlist.elements[i];
			if (e.checked==true)
			{
				 qx=1;
			}
	}
 	if (qx==0){
	 window.alert("请选择权限!");
	 return false;
	}
  return true;
}


 //管理员添加页add/edit JS验证
function checkmanager_edit(formlist){
  if (checkspace(formlist.username.value))
  {
    alert("请输入管理帐号！");
    formlist.username.focus();
    return false;
  }

 if (formlist.password.value!=formlist.password1.value)
  {
    alert("请保证两次密码一致！");
    formlist.password1.focus();
    return false;
  }
  var qx=0;

 	for (var i=0;i<document.formlist.elements.length;i++)
	{
		var e = document.formlist.elements[i];
			if (e.checked==true)
			{
				 qx=1;
			}
	}
 	if (qx==0){
	 window.alert("请选择权限!");
	 return false;
	}
  return true;
}
