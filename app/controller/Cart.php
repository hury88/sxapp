<?php
class Cart extends KWAction
{
	private $shopCar=null;


	public function index(){
		$addressId = I('get.addressId', 0, 'intval');
		if (! $addressId) {
			if ($uid = Person::get()->_pk) {
				$addressId = M('usr_address')->where('uid='.$uid)->order('is_default desc')->getField('id');
			}
		}

		$this->assign('address', M('usr_address')->find($addressId));
		$acar = $this->shopCar->cart;
		$goodMD = KWFactory::create('GoodsModel');
		foreach ($acar as $goods_id => &$value) {
			if ($goods_info = $goodMD->field('*')->find($goods_id)) {
				$value = array_merge($value, $goods_info);
			} else {
				unset($acar[$goods_id]);
			}
		}
		$this->assign('list', $acar);
		$this->display('cart');
	}

	public function addRequest()
	{
		$cart = isset($_POST['cart']) ? $_POST['cart'] : [];
		if ($cart) {
			foreach ($cart as $gid => $num) {
				if (! $this->shopCar->addGoods(intval($gid), intval($num)) ) {
					dieJson(3, $this->shopCar->error);
				}
			}
			dieJson(-1, '添加购物车成功', U('cart'));
		} else {
			dieJson(1, '请选择商品');
		}
	}

	public function __construct()
	{
		$this->shopCar = new ShopCar(Person::get()->_pk);
	}

}
