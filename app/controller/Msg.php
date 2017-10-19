<?php
class Msg extends KWAction
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

	public function index()
	{
		$mid = I('get.mid', 0, 'intval');
		if ($mid) {// 查看消息详情
		    $this->assign(M('order')->find($mid));
		    $this->assign('list', M('order_goods')->where(['order_id'=>$mid])->order('order_goods_id desc')->select());
		    $this->display('usr/msg/view');
		} else {// 消息列表
			$uid = $this->getUserData('id');
			$regtime = $this->getUserData('regtime');
			$msg_res =  MsgBox::getData($uid,$regtime);
		    $this->assign('list',$msg_res);
		    $this->display('usr/msg/list');
		}
	}

	private function getUserData($field) {
		return $field ? $this->_data[$field] : $this->_data;
	}

}
