<?php
class Register extends KWAction
{
	public function __construct()
	{
		if ( Person::get()->exist() ) {
			$this->redirect('usr');
		}
	}

	public function index(){
		$this->assign('registerRequest', U('register/registerRequest'));
		// $this->assign('registerSendSMS', U('yzm/registerSendSMS'));
		$this->assign('loginView', U('login/index'));
		$this->display('usr/register');
	}

	//用户注册
	public function registerRequest(){
		// 提交来注册的
		$verify = [
			'telphone' => ['required', config('tips.phone')],
			'password' => ['password', config('tips.password')],
			'yzm' => ['required', config('tips.yzm')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		$telphone = $form->telphone;
		#判断用户是否存在
		if (Person::get()->has('mobile', $telphone)) {
			returnJson(-100, config('tips.reg_mobile_existed'));
		}
		#验证码错误
		if (! Yzm::verify($telphone)) {
			returnJson(-100, config('tips.yzm_error'));
		};

		$data = [
			'mobile'  => $telphone,
			'password'  => $form->md5($form->password, $form->yzm),
			'randcode'  => $form->yzm,
			'lastloginip'    => $form->ip(),
			'lastlogintime'  => $form->time(),
			'regtime'   => $form->time(),
		];

		// dump($data);exit;

		if ( $userId = $this->PersonModel->insert($data) ) {
			#清空验证码信息
			Yzm::clear($telphone);
			Person::get($userId)->login();
			returnJson(200, config('tips.reg_success'), U('usr'));
		} else {
			returnJson(-100, config('tips.reg_failed'));
		}

	}



}
