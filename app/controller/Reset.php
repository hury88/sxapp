<?php
class Reset extends KWAction
{
	public function __construct()
	{
		if (! Person::get()->exist() ) {
			$this->redirect('login');
		}
	}

	public function index(){
		$this->assign('resetRequest', U('reset/resetRequest'));
		$this->display('usr/reset');
	}

	//用户注册
	public function resetRequest(){
		$_POST['new'] = $_POST['password']['new'];
		$_POST['old'] = $_POST['password']['old'];
		// 提交来注册的
		$verify = [
			'old' => ['required', config('tips.orignPassword')],
			'new' => ['password', config('tips.newPassword')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		// 获取用户数据
		$user = Person::get()->getData();
		$new = VerifyForm::md5($form->new, $user['randcode']);
		$old = VerifyForm::md5($form->old, $user['randcode']);
		#密码校验
		if ($old == $user['password']) {
			if ($new == $old) {
				returnJson(-100, config('tips.newEqualsOld'));
			} else {
				//更新密码
				if ( Person::get()->save(['password' => $new]) ) {
					returnJson(200, config('tips.modifyData_success'), U('usr/setup'));
				};
				returnJson(-100, config('tips.modifyData_failed'));
			}
		} else {
			returnJson(-100, config('tips.orignPassword_confirm_failed'));
		}

	}



}
