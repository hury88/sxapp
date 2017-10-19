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
		$oid = I('get.oid', 0, 'intval');
		if ($oid) {// 查看订单详情
		    $this->assign(M('order')->find($oid));
		    $this->assign('list', M('order_goods')->where(['order_id'=>$oid])->order('order_goods_id desc')->select());
		    $this->display('order/view');
		} else {// 订单列表
			$buyer_id = $this->getUserData('id');
		    $this->assign('list', M('order')->where(['buyer_id'=>$buyer_id])->order('order_status asc,id desc')->select());
		    $this->display('order/list');
		}
	}

	private function getUserData($field) {
		return $field ? $this->_data[$field] : $this->_data;
	}

}
