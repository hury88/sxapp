
function change_yzm() {
	var num = 	new Date().getTime();
	var rand = Math.round(Math.random() * 10000);
	num = num + rand;
	if ($("#vdimgck")[0]) {
		$("#vdimgck")[0].src = "/include/yzm.php?tag=" + num;
	}
	return false;
}

//删除信息验证
function ConfirmDelInfo()
{
   if(confirm("确定要删除此信息吗？删除后不能恢复！"))
     return true;
   else
     return false;

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

function fun(targ,selObj,restore){
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}

//加入收藏
function AddFavorite(sURL, sTitle) {
	sURL = encodeURI(sURL);
	try{
		window.external.addFavorite(sURL, sTitle);
	}catch(e) {
		try{
			window.sidebar.addPanel(sTitle, sURL, "");
		}catch (e) {
			alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.");
		}
	}
}
//设为首页
function SetHome(url){
	if (document.all) {
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);

	}else{
		alert("您好,您的浏览器不支持自动设置页面为首页功能,请您手动在浏览器里设置该页面为首页!");
	}
}


function check_comments(formlist){
   	if (formlist.myd.value==0)
	{
		alert("请选择满意度！");
		formlist.myd.focus();
		return false;
	}
   	if (formlist.zyd.value==0)
	{
		alert("请选择专业度！");
		formlist.zyd.focus();
		return false;
	}
   	if (checkspace(formlist.content.value))
	{
		alert("请输入评论内容！");
		formlist.content.focus();
		return false;
	}
}


function check_name(checkRule){
   	switch(checkRule){
   		case 'tel':
   		reg = /^1[3|4|5|7|8][0-9]{9}$/;
   			return br(reg.test(value));
   		break;
   		case 'realname':
   		reg = /^.{2,10}$/;
   		if(br(reg.test(value))){
   			return true;
   		}else{
   			alert('姓名长度应为2-10位');
   			return false;
   		}
   		break;
   		case 'email':
   		reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
   			return br(reg.test(value));
   		break;
   		case 'phone':
   		reg = /^0\d{2,3}-?\d{7,8}$/;
   			return br(reg.test(value));
   		break;
   	}
   	return true;
}


function check_message(formlist){
   	if(checkspace(formlist.thename.value) || formlist.thename.value=='填写姓名'){
   		alert("请输入姓名！");
		formlist.thename.focus();
		return false;
	}
   	if(checkspace(formlist.thepassword.value) || formlist.thepassword.value=='联系电话'){
   		alert("请输入密码！");
		formlist.thepassword.focus();
		return false;
	}
   /*	if(checkspace(formlist.email.value) || formlist.email.value=='电子邮箱'){
   		alert("请输入Email！");
		formlist.email.focus();
		return false;
	}
   	if(checkspace(formlist.company.value) || formlist.company.value=='公司名称'){
   		alert("请输入公司名称！");
		formlist.company.focus();
		return false;
	}

   	if(checkspace(formlist.message.value) || formlist.message.value=='填写详细要求'){
   		alert("请输入留言！");
		formlist.message.focus();
		return false;
	}

	if(checkRegExp('tel',formlist.phone.value)){
		alert('手机格式不正确');
		formlist.phone.focus();
		return false;
	}
	if(checkRegExp('email',formlist.email.value)){
		alert('邮箱格式不正确');
		formlist.email.focus();
		return false;
	}*/
   	return true;
}
function br(bool){
	return bool ? false : true;
}
function checkRegExp(checkRule,value){
	switch(checkRule){
		case 'tel':
		reg = /^1[3|4|5|7|8][0-9]{9}$/;
			return br(reg.test(value));
		break;
		case 'email':
		reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
			return br(reg.test(value));
		break;
		case 'phone':
		reg = /^0\d{2,3}-?\d{7,8}$/;
			return br(reg.test(value));
		break;
	}

}


function check_search(frm){
	if(checkspace(frm.q.value) || frm.q.value=='请输入待搜索的关键字'){
		alert('请输入搜索关键词！');
		frm.q.focus();
		return false;
	}
	return true;
}

function check_orders(formlist){
    if (checkspace(formlist.email.value))
	{alert("请输入邮箱！");
	formlist.email.focus();
	return false;
	}
   	if (checkspace(formlist.message.value))
	{alert("请输入建议！");
	formlist.message.focus();
	return false;
	}
}


