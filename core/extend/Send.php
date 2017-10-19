<?php

class Send
{
    public static $sms_config =null;
    function __construct(){}

    /**
     * [smtp_config smtp邮件配置及发送]
     */
	public static function mail($mailbox, $title, $msg){
		$smtp_server  = 'smtp.126.com';
		$smtp_user    = 'jiygora@126.com';
		$smtp_pwd     = 'semJiygo88';   //您登录smtp服务器的密码
		$smtp_subject = '';	//标题
		$smtp_body    = '';	//内容
		$smtp = new Smtp($smtp_server,$smtp_user,$smtp_pwd);
		$smtp_subject = $title;
		$smtp_body ='<p>'.$msg.'</p>';
		$emails = explode(',',$mailbox);
		foreach ($emails as $email) {
			if (! $smtp->sendmail($email,$smtp_subject,$smtp_body,'HTML')) {
				return false;
			}
		}
		return true;
	}

	public static function sms($phone, $postString)
	{
		return true;
		$statusStr = array(
		        "0" => "短信发送成功",
		        "-1" => "参数不全",
		        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
		        "30" => "密码错误",
		        "40" => "账号不存在",
		        "41" => "余额不足",
		        "42" => "帐户已过期",
		        "43" => "IP地址限制",
		        "50" => "内容含有敏感词"
		    );
		$smsapi = "http://www.smsbao.com/"; //短信网关
		$user = "shangtuan"; //短信平台帐号
		$pass = md5("aini1wannian"); //短信平台密码
		$content=$codeTemp;//要发送的短信内容
		$phone = $phone;
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		$result =file_get_contents($sendurl) ;
		return $result;
	}

}
?>