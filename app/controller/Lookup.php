<?php
class Lookup extends KWAction
{
	public function __construct()
	{
		if ( Person::get()->exist() ) {
			$this->redirect('usr');
		}
	}

	public function index(){
		$this->assign('request', U('lookup/request'));
		$this->display('usr/lookup');
	}

	//用户注册
	public function request(){
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
		];

		#判断用户是否存在
		if ($usr = Person::get()->has('mobile', $telphone)) {
			$data['id'] = $usr['id'];
			if ( $userId = $this->PersonModel->update($data) ) {
				#清空验证码信息
				Yzm::clear($telphone);
				Person::get($userId)->login();
				returnJson(200, config('tips.lookup_success'), U('usr'));
			} else {
				returnJson(-100, config('tips.lookup_failed'));
			}
		} else {
			$data['regtime'] = $form->time();
			if ( $userId = $this->PersonModel->insert($data) ) {
				#清空验证码信息
				Yzm::clear($telphone);
				Person::get($userId)->login();
				returnJson(200, config('tips.lookup_success'), U('usr'));
			} else {
				returnJson(-100, config('tips.lookup_failed'));
			}
		}

		// dump($data);exit;


	}



}
