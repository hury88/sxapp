<?php
/**
 * @class ShopCar
 * @brief 购物车类
 */
class ShopCar extends KWModel
{
	const TABLE = 'cart';
	#存储购物车数据
	public $cart;

	/*购物车复杂存储结构
	* [id]   :array  商品id值;
	* [num]:int    商品数量;
	* [info] :array  商品信息 [goods]=>array( ['id']=>商品ID , ['data'] => array( [商品ID]=>array ( [sell_price]价格, [count]购物车中此商品的数量 ,[type]类型goods,product ,[goods_id]商品ID值 ) ) ) , [product]=>array( 同上 ) , [count]购物车商品和货品数量 , [sum]商品和货品总额 ;
	* [sum]  :int    商品总价格;
	*/
	private $cartExeStruct = array('goods' => array('id' => array(), 'data' => array() ),'product' => array( 'id' => array() , 'data' => array()),'count' => 0,'sum' => 0);

	//购物车名字前缀
	private $cartName    = 'cart';

	//购物车中最多容纳的数量
	private $maxCount    = 100;

	//错误信息
	public $error       = '';

	//购物车的存储方式
	private $saveType    = 'cookie';

	//购物车的存储方式
	private $isLogin    = false;


	/**
	 * 添加商品
	 */
	public function addGoods($gid, $num, $bl_id=0)
	{
	    // 检测当前购物车中是否存在此产品
	    if ( isset($this->cart[$gid]) ) {
	    	$this->cart[$gid]['num'] += $num;
	    } else {
	    	$this->cart[$gid] = [
	    		'num' => $num,
	    	];
	    }
	    if ($this->cart[$gid]['num'] > Good::get($gid)->stock) {
	    	$this->error = config('tips.cart')['un_stock'];
	    	return false;
	    }
	    $this->syncCart();
	    return true;
	}

	/**
	 * 添加商品
	 */
	public function removeGoods($gid)
	{
	    // 检测当前购物车中是否存在此产品
	    if (isset($this->cart[$gid])) {
	    	unset($this->cart[$gid]);
		    $this->syncCart();
	    	return true;
	    }
	    return false;
	}

	public function getGoodsCount()
	{
		$count = 0;
		foreach ($this->cart as $gs) {
			$count += $gs['num'];
		}
		return $count;
	}

	//写入购物车
	private function syncCart()
	{
		if ($this->isLogin) {
			$result = $this->save(['cart_info'=>$this->enJson()]);
		} else {
			$result = $this->noDB('set');
		}
		return $result;
	}

	private function noDB($action)
	{
		switch ($action) {
			case 'get':
				$res = $this->saveType == 'cookie' ? cookie($this->cartName) : session($this->cartName);
				return $res ? : [];
				break;
			case 'set':
				return $this->saveType == 'cookie' ? cookie($this->cartName, $this->cart) : session($this->cartName, $this->cart);
				break;
			default:
				return NULL;
				break;
		}
	}

	public function __construct($uid=null)
	{
		if (is_null($uid)) $uid = Person::get()->_pk;
		// 用户未登录
		if (is_null($uid)) {
			$this->isLogin = false;
			$this->cart = $this->noDB('get');
		} else {
			$this->isLogin = true;
			$this->MD = M(self::TABLE);
			// 购物车表
			if ( $this->_data = $this->MD->field('id,cart_info')->where('buyer_id='.$uid)->find() ) {
				$this->cart = $this->deJson($this->_data['cart_info']);
			} else {
				$this->_pk = $this->MD->insert(['buyer_id'=>$uid]);
				$this->cart = [];
			}
		}
	}

	// 数组=>json
	private function enJson() { return json_encode((array) $this->cart);}
	// json=>数组
	private function deJson($json) { return json_decode($json, true) ? : [];}
}
