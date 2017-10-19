<?php
class Yzm
{
	private $debug = false;
	private static $var = 'yzm';
	private static $var_expire = 'yzm_expire';
	public $form = null;

	public function __construct()
	{
		$this->debug = config('app_debug');
		/*#验证码未过期.不可再次发送
		if ( $this->expired() ) {
			returnJson(-100, config('tips.yzm_expired'));
		}*/
	}


	public function mailbox()
	{
		$verify = [
			'first' => ['required', config('tips.first')],
			'last' => ['required', config('tips.last')],
			'country' => ['required', config('tips.country')],
			'email' => ['email', config('tips.email')],
			'password' => ['password', config('tips.password')],
		];
		$form = new VerifyForm($verify, 'post');
		#表单信息不完整
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		#邮件->发送验证
		$code = $this->setCode();
		if (Send::mail($form->email, 'The captcha from CIP',  "Your CAPTCHA is $code")) {
			returnJson(-100, config('tips.mail_success'));
		} else {
			returnJson(-100, config('tips.mail_failed'));
		}
	}

	public function mobile()
	{
		$verify = [
			// 'first' => ['required', config('tips.first')],
			// 'last' => ['required', config('tips.last')],
			// 'country' => ['required', config('tips.country')],
			'telphone' => ['required', config('tips.phone')],
			'password' => ['password', config('tips.password')],
		];
		$form = new VerifyForm($verify, 'post');
		#表单信息不完整
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		$telphone = $form->telphone;
		#验证码未过期.不可再次发送
		if ( $this->expired($telphone) ) {
			returnJson(-100, config('tips.yzm_expired'));
		}
		#邮件->发送验证
		$code = $this->setCode($telphone);
		if (Send::sms($form->phone, $code)) {
			returnJson(-100, config('tips.sms_success') . ',验证码为:' . $code );
		} else {
			returnJson(-100, config('tips.sms_failed'));
		}
	}

	//发送验证码
	public function registerSendSMS()
	{
		$verify = [
			'telphone' => ['required', config('tips.phone')],
			'password' => ['password', config('tips.password')],
		];
		$form = new VerifyForm($verify, 'post');
		#表单信息不完整
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		$telphone = $form->telphone;
		#判断用户是否存在
		if (Person::get()->has('mobile', $telphone)) {
			returnJson(-100, config('tips.reg_mobile_existed'));
		}
		#验证码未过期.不可再次发送
		if ( $this->expired($telphone) ) {
			returnJson(-100, config('tips.yzm_expired'));
		}
		#邮件->发送验证
		$code = $this->setCode($telphone);
		if (Send::sms($form->phone, $code)) {
			returnJson(101, config('tips.sms_success') . ',验证码为:' . $code );
		} else {
			returnJson(-100, config('tips.sms_failed'));
		}
	}
	//发送验证码
	public function lookupSendSMS()
	{
		$verify = [
			'telphone' => ['required', config('tips.phone')],
			'password' => ['password', config('tips.password')],
		];
		$form = new VerifyForm($verify, 'post');
		#表单信息不完整
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		$telphone = $form->telphone;
		#验证码未过期.不可再次发送
		if ( $this->expired($telphone) ) {
			returnJson(-100, config('tips.yzm_expired'));
		}
		#邮件->发送验证
		$code = $this->setCode($telphone);
		if (Send::sms($form->phone, $code)) {
			returnJson(101, config('tips.sms_success') . ',验证码为:' . $code );
		} else {
			returnJson(-100, config('tips.sms_failed'));
		}
	}

	public function reset()
	{
		$verify = [
			'usrname' => ['required', config('tips.usrname')],
			'pasword' => ['password', config('tips.password')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		$form_usrname = $form->usrname;
		#邮件->发送验证
		$code = $this->setCode();
		$hasField = strpos($form_usrname, '@') ? 'email' : 'phone';
		$title = Config('tips.email_title');
		switch ($hasField) {
			case 'email':
				if (Send::mail($form_usrname, $title, $code)) {
					returnJson(-100, config('tips.mail_success') . $code);
				} else {
					returnJson(-100, config('tips.mail_failed'));
				}
				break;
			case 'phone':
				if (Send::sms($form_usrname, $code)) {
					returnJson(-100, config('tips.sms_success') . $code );
				} else {
					returnJson(-100, config('tips.sms_failed'));
				}
				break;
		}
	}

	public function expired($id)
	{
		if ($this->debug) {
			return false;
		} else {
			if (isset($_SESSION[self::$var][$id])) {
				return time() - $_SESSION[self::$var][$id][self::$var_expire] < 0;
			} else {
				return false;
			}
		}
	}

	public function setCode($id, $time = 63)
	{
		if (!isset($_SESSION[self::$var]) || is_array($_SESSION[self::$var])) {
			$_SESSION[self::$var] = [];
		}
		$_SESSION[self::$var][$id][self::$var_expire] = time() + $time;
		$code = $_SESSION[self::$var][$id][self::$var] = getCode(6, GETCODE_NUMBER);
		return $code;
	}

	public static function clear($id)
	{
		if (isset($_SESSION[self::$var][$id])) {
			$_SESSION[self::$var][$id][self::$var_expire] = time();
			$_SESSION[self::$var][$id][self::$var] = '';
		}
	}

	/**
	 * Prevents Cross-Site Scripting Forgery
	 * @return boolean
	 */
	public static function verify($id) {
		if ( isset($_SESSION[self::$var][$id]) ) {
			if( isset($_GET[self::$var]) && strtolower($_GET[self::$var]) == strtolower($_SESSION[self::$var][$id][self::$var]) ) {
				return true;
			}
			if( isset($_POST[self::$var]) && strtolower($_POST[self::$var]) == strtolower($_SESSION[self::$var][$id][self::$var]) ) {
				return true;
			}
		}
		return false;
	}

}
