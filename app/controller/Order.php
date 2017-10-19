<?php
class Order extends KWAction
{
	/**
	 * [send 第三方支付接口测试]
	 * @return [type] [description]
	 */
	public function send(){

		        //获取订单号
		        $postid = $_SESSION['postid'];

		        if(empty($postid)){
		        	//订单号为空
		        	$this->status = -1;
		        	$this->display('Pay/result');
		        	return;
		        }
		        $find_postid = M('Orders')->where(array('postid'=>$postid,'uid'=>$_SESSION['u_id']))->find();

		        if(!$find_postid){
		        	//订单不存在
		        	$this->status = -2;
		        	$this->postid = $postid;
		        	$this->display('Pay/result');
		        	return;
		        }


		        //收集数据
		        $post_data = array(
		        	'v_oid'        =>     $postid,/*订单号*/
		        	'v_amount'     =>     $find_postid['total'],/*支付金额*/
		        );

		        $postUrl = $_SERVER['HTTP_HOST'].'/payment/chinabank/Send.php';
		        curl_post($postUrl,$post_data);
	}



	public function submit(){
		/*		Array
		(
		    [payid] => 1
		    [pids] => 7,3,2
		    [consignee_id] => 6
		)*/
		$cid = I('post.consignee_id',0,'intval');
		$payid = I('post.payid',0,'intval');
		$pids = $_POST['pids'];

		$data = array();
		$data['status'] = 0;
		$data['messag'] = '';
		//获取收货人信息
		$find = M('Consignee')->where('uid='.$_SESSION['u_id'])->find($cid);
		if(!$find){
			$data['status'] = -2;
			$data['messag'] = '获取地址信息失败,请完善收获人信息';
			$this->ajaxReturn($data);
		}
		//获取商品信息
		list($select,$trade) = $this->getGoodsInfo($pids);
		if(empty($select)||empty($trade)){
			$data['status'] = -4;
			$data['messag'] = '获取商品信息失败';
			$this->ajaxReturn($data);
		}
			#判断商品是否 满足 库存
				#判断商品的状态 ,1有货,0无货,-1库存不足
				foreach ($select as $key => $value) {
					switch ($value['stock_empty']) {
						case 1:
							$data['status'] = 1;
							$data['messag'] = '库存ok';
							#无需返回
							//$this->ajaxReturn($data);
							continue;
						case 0:
							$data['status'] = -3;
							$data['messag'] = '无货';
							$data['title']  = $value['title'];
							$this->ajaxReturn($data);
							break;
						case -1:
							$data['status'] = -1;
							$data['messag'] = '有货,但库存不足';
							$data['title']  = $value['title'];
							$this->ajaxReturn($data);
							break;
						default:
							$data['status'] = 0;
							$data['messag'] = '未能捕捉错误,商品可能已下架';
							$this->ajaxReturn($data);
							break;
					}
				}//下单商品成功
				$order = array();

				$temp['province'] = $find['province'];
				$temp['city'] = $find['city'];
				$temp['area'] = $find['area'];
				$temp = getRegion($temp);

				//生成订单号
				$postid = substr(time(),0,6).mt_rand(10000,99999);
				//查表判断订单id是否有重复
				if(M('Orders')->where('postid='.$postid)->find() > 0){
					$data['status'] = -5;
					$data['messag'] = '下单失败,请重新尝试';
					$this->ajaxReturn($data);
				}

				$order['postid'] = $postid;
				$order['uid']    = $_SESSION['u_id'];
				$order['total']  = $trade['total'];/*订单总价*/
				$order['name']   = $find['name'];
				$order['mobile'] = $find['mobile'];
				$order['address'] = implode('',array_values($temp)).$find['addr'];
				$order['express'] = '';
				$order['status']  = 1;
				$order['paystyle']  = $payid;
				$order['playtime']  = date('Y-m-d h:i:s');

				//###开启事物#建立个flag
				M()->startTrans();
				$flag = false;
				####################
					#1)尝试存储订单
					$oid = M('Orders')->add($order);
					#2)清除购物车
					$Cart = new \Org\Own\Cart();
					$delNum = $Cart->popCart($pids);
				if($oid > 0 && $delNum >0):
						$flag = true;
						#3) 存储goods_item
						#$select : getGoodsInfo返回值之一
						$datalist=array();
						foreach ($select as $key => $value) {
							//$value 每个商品的信息

							$datalist = array(
								'oid' => $oid,
								'uid' => $_SESSION['u_id'],
								'pid' => $value['pid'],
								'pnum' => $value['pnum'],
								'img' => $value['img'],
								'title' => $value['title'],
								'price' => $value['n_price'],
								'pstatus' => 1,
							);
							#3)保存到订单明细表goods_item
							#4)修改商品数量
							if(!M('GoodsItem')->add($datalist) || !M('Product')->where('id='.$value['pid'])->setDec('stock',$value['pnum']) ) :
									$flag = false;
									break;
							endif;
						}
				endif;

				if($flag) :
						$log = array();

						$log['oid'] = $oid;
						$log['uid'] = $_SESSION['u_id'];
						$log['type'] = 1;/*新订单*/
						$log['remark'] = '';
						$log['addtime'] = $order['playtime'];
						#3)更新订单日志
						if(M('OrderLog')->add($log) > 0):
								M()->commit();
								$data['status'] = 2;
								$data['messag'] = '下单成功';
								// 保存订单号
								$_SESSION['postid'] = $postid;
								$_SESSION['payid'] = $payid;
								$this->ajaxReturn($data);
							else:
								$flag = false;
						endif;//日志表End
				endif;//明细表End

				if(!$flag):
					M()->rollback();
					$data['status'] = -5;
					$data['messag'] = '下单失败,请重新尝试';
					$this->ajaxReturn($data);
				endif;
	}


	//订单结算页
	public function trade(){

		//如果直接打开此页面 直接跳转
		if(empty(I('get.goodspids')))$this->redirect('Cart/index');

		//查询原来的收货信息地址default
		$default = M('User')->alias('u')->join('left join tp_consignee c ON u.u_id=c.uid where u.cid=c.id and u.u_id='.$_SESSION['u_id'])->find();
		if(empty($default)) :
			$this->assign('notDefault',1);
			$default = M('Consignee')->where(array('uid'=>$_SESSION['u_id']))->find();
		endif;

		if(!empty($default)) :

				$data['province'] = $default['province'];
				$data['city'] = $default['city'];
				$data['area'] = $default['area'];
				//将 地区id 替换成 地址
				$default = array_merge($default,getRegion($data));
				$this->assign($default);
			else:
				//否则 标记为第一次下单 提示完善收货信息
				$this->assign('first',1);
		endif;

		//商品列表
		//获取商品列表
		/*
		 Array
		 (
		     [0] => Array
		         (
		             [id] [uid] [pid] [pnum] [addtime] [thumb] [n_price] [stock] [title] [stock_empty])
		         )
		 */
		//根据商品id 获取 商品信息
		list($select,$trade) = $this->getGoodsInfo($_GET['goodspids']);
		//这里可以判断 商品是否已下架
		if($select):
				$this->assign('goods_list',$select);
				$this->assign('trade',$trade);
			else:
				$this->assign('error','获取信息失败,请尝试返回购物车,重新确认商品');
		endif;

		//连表查询 产品 信息

		$this->display('Index/trade');
	}


	/**
	 * $$$判断产品是否存在 : 后期可加上
	 * 或trade页 商品所有信息
	 * 返回一个二维数组
	 * cart_product: 每个商品的储存信息
	 * $trade 所有商品的信息 如 总价 总数
	 */
	private function getGoodsInfo($pids){
		$cart_product = array();
		$trade = array();

		if(!empty($pids)) :
			$cart_product = M('Cart')->alias('ca')->join('left join `tp_product` p ON ca.pid=p.id where ca.uid='.$_SESSION['u_id'].' and `pid` in('.$pids.')')->order('ca.addtime desc')->select();
				$trade['total'] = 0;
				$trade['amount'] = 0;

				#计算总价
			foreach ($cart_product as $key => &$value) {

				$trade['total'] += $value['pnum']*$value['n_price'];
				$trade['amount'] += $value['pnum'];
				//判断商品的状态 ,1有货,0无货,-1库存不足
				if($value['stock'] == 0):
					$value['stock_empty'] = 0;
					else:
					$value['stock_empty'] =	$value['pnum'] > $value['stock'] ?  -1 : 1;
				endif;
			}
			//保留小数
			$trade['total'] = sprintf('%.2f',$trade['total']);

		endif;
		return array($cart_product,$trade);
	}


	public static function getOrderGoods($oid){
		$list = M('order_goods')->where("order_id=$oid")->select();
		return $list?:[];
	}
}
