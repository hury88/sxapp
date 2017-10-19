<?php
class Usr extends KWAction
{
	protected $_usr = null;
	protected $_data;
	public function __construct()
	{
		$this->_usr = Person::get();
		if ( $this->_usr->exist() ) {
			$this->_data = $this->_usr->getData();
		} else {
			$this->redirect('index');
		}
	}

	public function index()
	{
		$this->assign('setupView', U('usr/setup'));

		$headimg = src($this->_data['headimg'], 'headImage', 'headImageDefault');
		$this->assign('userName', $this->_data['name'] ? : $this->_data['mobile']);
		$this->assign('headImage', $headimg);

		$this->display('usr/index');
	}
	// 设置页面
	public function setup()
	{
		$this->display('usr/setup');
	}

	// 个人信息
	public function myinfo()
	{
		$this->assign('headImage', src($this->_data['headimg'], 'headImage', 'headImageDefault'));
		$this->display('usr/myinfo');
	}

	//新品需求
	public function need()
	{
		if (is_post()) {
			// 提交来注册的
			$verify = [
				'proposal' => ['required', config('tips.proposal')],
			];
			// 手机号可不填 填写了就要验证
			if (isset($_POST['telphone']) && $_POST['telphone']) {
				$verify['telphone'] = ['need', config('tips.phone')];
			} else {
				$verify['telphone'] = ['need', config('tips.phone')];
			}

			$form = new VerifyForm($verify, 'post');
			#验证不通过
			if ($form->result()) {
				returnJson(-100, $form->error, $form->field);
			}

	        // $image = new Image();
		    // $image->open($_FILES['img'])->save('./1.jpg');
			#上传图片
			$data = [
				'uid' => $this->_data['id'],
				'proposal' => $form->proposal,
				'mobile' => $form->telphone,
				'sendtime' => $form->time(),
			];
			$needimg = uppro('img', config('pic.needImage'));
			if ( $needimg ) {
				$data['img'] = $needimg;
			} elseif($needimg === false ) {
				returnJson(200, config('tips.submit_failed'));
			}
			// 记录
			$insert = $this->usr_needModel->insert($data);

			if ($insert) {
				returnJson(200, config('tips.submit_success'));
			} else {
				returnJson(-100, config('tips.submit_failed'));
			}

		} else {
			$this->assign('needRequest', config('__url__'));
			$this->display('usr/need');
		}
	}
/*
	public static function insert($data)
	{
		// dump($data);
		// exit;
		isset($data['phone ']) && $data['phone'] = preg_replace('/^[+][a-z0-9]+[\s]+/', '', $data['phone']);
		if ( $data['phone'] && self::has('phone', $data['phone']) ) {
			return false;
		} elseif( $data['email'] && self::has('email', $data['email']) ) {
			return false;
		} else {
			return M(self::$table)->insert($data);
		}
	}

	public static function update($where, $data)
	{
		return M(self::$table)->where($where)->update($data);
	}

	//单例初始化
	public static function get($id=null)
	{
	    $id = $id ?: cookie('userId');
	    if (!isset(self::$_cache[$id])){
	        self::$_cache[$id] = new self($id);
	    }
	    return self::$_cache[$id];
	}*/


	/*public function __get($key)
	{
		echo isset(self::$data[$key]) ? self::$data[$key] : '';
	}

	public function __set($key, $value)
	{
		self::$data[$key] = $value;
	}*/

}
