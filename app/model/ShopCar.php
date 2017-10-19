<?php
/**
 * @class ShopCar
 * @brief 购物车类
 */
class ShopCar extends KWModel
{
	const TABLE = 'cart';
	const operator_rising = '+';
	const operator_reduce = '-';
	const operator_assign = '=';

	#存储购物车数据
	public $cart;

	/*购物车复杂存储结构
	* [id]   :array  商品id值;
	* [num]:int    商品数量;
	* [info] :array  商品信息 [goods]=>array( ['id']=>商品ID , ['data'] => array( [商品ID]=>array ( [sell_price]价格, [count]购物车中此商品的数量 ,[type]类型goods,product ,[goods_id]商品ID值 ) ) ) , [product]=>array( 同上 ) , [count]购物车商品和货品数量 , [sum]商品和货品总额 ;
	* [sum]  :int    商品总价格;
	*/
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

	public function push($gid, $num=0, $operate=self::operator_rising){
		if (is_array($gid)) {
			foreach ($gid as $id => $num) {
				if (! $this->addOneGood((int)$gid, (int)$num, $operate)) {
					unset($this->cart[$id]);
				}
			}
			return true;
		} else {
			return $this->addOneGood((int)$gid, (int)$num, $operate);
		}
	}

	public function pop($gids){
		if (is_array($gid)) {
			foreach ($gid as $id => $num) {
				$this->removeOneGood($gid);
			}
		} else {
			$this->removeOneGood($gid);
		}
		$this->syncCart();
	}
	/**
	 * 添加一个商品
	 */
	public function addOneGood($gid, $num, $operate)
	{
	    // 检测当前购物车中是否存在此产品
	    if ($this->detection_good($gid, $num)) {
			$this->aog_good_cal($gid, $num, $operate);
		    $this->syncCart();
		    return true;
	    }
	    return false;
	}

	/**
	 * 添加商品
	 */
	public function removeOneGood($gid)
	{
	    // 检测当前购物车中是否存在此产品
	    if (isset($this->cart[$gid])) {
	    	unset($this->cart[$gid]);
	    	return true;
	    }
	    return false;
	}

	private function aog_good_cal($gid, $num, $operate)
	{
		if (isset($this->cart[$gid])) {
			switch ($operate) {
				case self::operator_rising:
					$this->cart[$gid] += $num;
					break;
				case self::operator_reduce:
					$this->cart[$gid] -= $num;
					break;
				case self::operator_assign:
					$this->cart[$gid] = $num;
					break;
				default :
					$this->cart[$gid] = 1;
					break;
			}
		} else {
			$this->cart[$gid] = $num;
		}
		if ($this->cart[$gid] <= 0) {
			unset($this->cart[$gid]);
		}

	}

	private function detection_good($gid) {
			// 有效商品id
		if ($gif = M('goods')->field('stock')->find($gid)) {
			$stock = $gif['stock'];
			// 检测库存
			if (isset($this->cart[$gid]) && $this->cart[$gid] > $stock) {
				$this->error = config('tips.cart')['good_stock_lack'];
				return false;
			}
			return true;
		} else {
			$this->error = config('tips_cart.good_404');
		}
		return false;
	}

	public function getGoodsCount()
	{
		$count = 0;
		foreach ($this->cart as $gs) {
			$count += $gs;
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
		if (is_null($uid)) $uid = Person::get()->getPk();
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
