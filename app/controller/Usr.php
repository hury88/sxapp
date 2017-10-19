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
			$this->redirect('login/index', ['r'=> base64_encode( U( config('controller').'/'.config('method') ) )]);
		}
	}

	public function addressList()
	{
	    $addresslist = M('usr_address')->where('uid='.$this->id)->order('is_default desc')->select();
	    $this->assign('items', $addresslist);
	    return $this->display('usr/addressList');
	}

	public function addressAdd()
	{
	    if (request()->isAjax()) {
	        $member = new MemberService();
	        $consigner = $_POST['consigner'];
	        $mobile = $_POST['mobile'];
	        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
	        $province = $_POST['province'];
	        $city = $_POST['city'];
	        $district = $_POST['district'];
	        $address = $_POST['address'];
	        $zip_code = isset($_POST['zip_code']) ? $_POST['zip_code'] : '';
	        $alias = isset($_POST['alias']) ? $_POST['alias'] : '';
	        $retval = $member->addMemberExpressAddress($consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
	        return AjaxReturn($retval);
	    } else {
	        $address_id = isset($_GET['addressid']) ? $_GET['addressid'] : 0;
	        $this->assign("address_id", $address_id);

	        return view($this->style . "/Member/addressInsert");
	    }
	}

	public function index()
	{
		$this->assign('setupView', U('usr/setup'));

		$headimg = src($this->_data['headimg'], 'headImage', 'headImageDefault');
		$bgimg = src($this->_data['bgimg'], 'headImage', 'bgImageDefault');
		$this->assign('userName', $this->_data['nickname'] ? : $this->_data['mobile']);
		$this->assign('headImage', $headimg);
		$this->assign('bgImage', $bgimg);

		$this->assign('order_count', Order::get()->count(['buyer_id'=>$this->id]));
		$this->assign('faqs_count', M('news')->where(m_gWhere(3,17))->count());

		$this->display('usr/index');
	}
	// 设置页面
	public function setup()
	{
		$this->display('usr/setup');
	}
	// 帮助中心
	public function faqs()
	{
		$this->assign('items', v_list('news', 'title,content', m_gWhere(3,17)));
		$this->display('usr/help');
	}

	// 个人信息
	public function myinfo()
	{
		$this->assign('myHeadImageRequest', U('usr/myHeadImageRequest'));
		$this->assign('headImage', src($this->_data['headimg'], 'headImage', 'headImageDefault'));
		$this->assign('bgImage', src($this->_data['bgimg'], 'headImage', 'bgImageDefault'));
		$this->assign('nickname', $this->_data['nickname']);
		$this->assign('gender', $this->_data['gender']);
		$this->assign('genderInfo', $this->_data['gender']==1?'男':($this->_data['gender']==2?'女':'未知'));
		$this->assign('mobileInfo', substr_replace($this->_data['mobile'],'******',3,6));
		$this->display('usr/myinfo');
	}

	//上传头像背景 更改昵称性别
	public function myHeadImageRequest()
	{
		$data = [
			'nickname' => I('post.nickname', '', 'trim,htmlspecialchars'),
			'gender' => I('post.gender', 0, 'intval'),
		];
		#上传图片 居中裁剪
		config('pic.imgsize', '210*210');
		$headimg = uppro('headimg', config('pic.headImage'), $this->_data['headimg'], md5($this->_data['id'].rand()), Image::IMAGE_THUMB_CENTER);
		if ( $headimg ) {
			$data['headimg'] = $headimg;
			// $this->_data['headimg'] && returnJson(200, config('tips.Tupload'));
		} elseif($headimg === false ) {
			returnJson(200, config('tips.Fupload'));
		}
		#上传背景图 居中裁剪
		config('pic.imgsize', '640*339');
		$bgimg = uppro('bgimg', config('pic.headImage'), $this->_data['bgimg'], 'bg_'.md5($this->_data['id'].rand()), Image::IMAGE_THUMB_SCALE);
		if ( $bgimg ) {
			$data['bgimg'] = $bgimg;
			// $this->_data['bgimg'] && returnJson(200, config('tips.Tupload'));
		} elseif($bgimg === false ) {
			returnJson(200, config('tips.Fupload'));
		}
		// 保存
		if (Person::get()->save($data)) {
			returnJson(200, config('tips.Tupload'));
		} else {
			returnJson(-100, config('tips.Fupload'));
		}
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
				returnJson(200, config('tips.submit_success'), U('usr/index'));
			} else {
				returnJson(-100, config('tips.submit_failed'));
			}

		} else {
			$this->assign('needRequest', config('__url__'));
			$this->display('usr/need');
		}
	}

	public function address()
	{
		$this->display('usr/address');
	}

}
