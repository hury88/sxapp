<?php
class Goods extends KWAction
{
	// 一级类目
	public function index(){
		$this->assign('nav', M('news_cats')->where('pid=1 and isstate=1')->order('disorder desc, id asc')->getField('id,img1') ? : []);
		$this->display('goods/menu');
	}
	// 二级类目
	public function submenu(){
		$category_id_1 = I('get.category_id_1', 0, 'intval');
		$this->assign('subnav', M('news')->field('id,title,img1')->where(['ty'=>$category_id_1,'isstate'=>1])->order('isgood desc, disorder desc, sendtime asc')->select() ? : []);
		$this->display('goods/submenu');
	}
	// 列表
	public function items($global){
		$condition = [];
		$category_id_2 = I('get.category_id_2', 0, 'intval'); $category_id_2 && $condition['category_id_2'] = $category_id_2;
		$global['q'] && $condition['goods_name'] = $global['q'];
		$this->assign('items', $this->GoodsModel->where($condition)->field('id as goods_id,goods_name,goods_name_added,market_price,price,img1')->where($condition)->order('is_recommend desc, disorder desc, sendtime asc')->select() ? : []);
		$this->assign('cart_goods_count', (new ShopCar)->getGoodsCount());
		$this->display('goods/items');
	}
	// 详情
	public function view($global){
		$objview = $global['view'];
		$this->assign('stockInfo', $objview->stock > 0 ? '<span class="fl">有货</span>' : '<span class="fl" style="color:red">无货</span>');
		$this->display('goods/view');
	}

}
