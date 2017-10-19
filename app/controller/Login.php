<?php
class Login extends KWAction
{
	public function __construct()
	{
		// cookie('userId', 1);
		if (config('method') != 'out' && Person::get()->exist() ) {
			$this->redirect('usr');
		}
	}
	public function index(){
		$this->assign('loginRequest', U('login/loginRequest'));
		$this->assign('registerView', U('register'));
		$this->assign('resetView', U('reset'));
		$this->display('usr/login');
	}

	public function out()
	{
		Person::get()->loginOut();
		$this->redirect('login/index');
	}

	//用户注册
	public function loginRequest(){
		// 提交来注册的
		$verify = [
			'telphone' => ['required', config('tips.phone')],
			'password' => ['password', config('tips.login_password_empty')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		#判断用户是否存在
		if ($user = Person::get()->has('mobile', $form->telphone)) {
			if ($user['password'] == VerifyForm::md5($form->password, $user['randcode'])) {
				Person::get($user['id'])->login();
				if ($redirect = I('post.r', '')) {
					$redirect = base64_decode($redirect);
				} else {
					$redirect = U('usr');
				}
				returnJson(200, config('tips.login_success'), $redirect);
			} else {
				returnJson(-100, config('tips.login_failed'));
			}
		} else {
			returnJson(-100, config('tips.login_failed'));
		}

	}



}
