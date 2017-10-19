<?php
/**
 *public function submit()     统一提交
 *#以下方法名对应表名称
 *public function news()      []
 *public function config()    []
 *public function content()   [] 映射->news表
 *public function news_cats() [] news_cats表(超级管理员用的)
 *public function pic()		  []
 *public function usr()		  []
 *public function goods()		  []
 */
class WithData
{

	protected $fields = [];
	protected $table = '';
	protected $isUpdate = 0;
	protected $isInsert = 0;
	protected $logInsert = '';// 插入数据时的日志
	protected $logUpdate = '';// 更新时的日志

	// 表映射
	private static $map = [
		'content' => 'news',
	];

	public function __construct($table, $id)
	{
		if ( $id ) {
			$this->isUpdate = $id;
		} else {
			$this->isInsert = 1;
		}

		$this->table  = $table;
		$this->fields = $this->$table();
		isset(self::$map[$table]) && $this->table = self::$map[$table];

	}


	// 提交数据
	public function submit()
	{
		$id        = $this->isUpdate;
		$table     = $this->table;
		$logUpdate = $this->logUpdate;
		$logInsert = $this->logInsert;
		if ( $id ) {// 执行更新

			$this->fields['id'] = $id;

			if($update = M($table)->update($this->fields) ) {

				$logUpdate && AddLog($logUpdate, $_SESSION['Admin_UserName']);

				return [1, '更新数据成功'];
			}else{
				return [0, '更新数据失败!'];
			}
		}else{// 执行插入

			$this->fields['isstate'] = 1;

			if($insert = M($table)->insert($this->fields) ) {

				$logInsert && AddLog($logInsert, $_SESSION['Admin_UserName']);

				return [6, '添加数据成功'];
			}else{
				return [5, '添加数据失败!'];
			}
		}
	}


	public function news()
	{
		$istop = I('post.istop',0,'intval');

		$relative = isset($_POST['relative']) && is_array($_POST['relative'])?implode(',',$_POST['relative']):'';
		$fields = array(
			'pid'				=>		I('pid', 0, 'intval'),
			'ty'				=>		I('ty' , 0, 'intval'),
			'tty'				=>		I('tty', 0, 'intval'),
			'title'				=>		I('post.title','','trim,htmlspecialchars'),
			'ftitle'			=>		I('post.ftitle','','trim,htmlspecialchars'),
			'content'			=>		I('post.content',''),
			'content2'       	=>		I('post.content2',''),
			'content3'       	=>		I('post.content3',''),
			'content4'       	=>		I('post.content4',''),
			'content5'       	=>		I('post.content5',''),
			'name'				=>		I('post.name','','trim'),
			'source'			=>		I('post.source','','trim,htmlspecialchars'),
			'relative'			=>		$relative,
			'introduce'			=>		I('post.introduce','','trim,htmlspecialchars'),
			'price'				=>		I('post.price','','trim,htmlspecialchars'),
			'linkurl'			=>		I('post.linkurl','','trim,htmlspecialchars'),
			'link1'				=>		I('post.link1','','trim,htmlspecialchars'),
			'link2'				=>		I('post.link2','','trim,htmlspecialchars'),
			#资讯
			'begin'      	=>		I('post.begin','','trim,htmlspecialchars'),
			//SEO
			'seotitle'		    =>		I('post.seotitle','','trim'),
			'keywords'		    =>		I('post.keywords','','trim'),
			'description'		=>		I('post.description','','trim'),

			'disorder'      	=>		I('post.disorder',0,'intval'),
			'hits'      		=>		I('post.hits',1,'intval'),
			'istop'      	 	=>		I('post.istop',0,'intval'),
			'istop2'      	 	=>		I('post.istop2',0,'intval'),
			'sendtime'      	=>		I('post.sendtime',0,'strtotime'),

		);
		/*if ($fields['ty'] == 9 && empty($fields['istop'])) {
			ajaxReturn(-1,'请选择案例分类');
		}*/
		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		uppro('img3',$fields,'ajax');
		uppro('img4',$fields,'ajax');
		uppro('img5',$fields,'ajax');
		uppro('img6',$fields,'ajax');
		uppro('file',$fields,'file');
		// uppro('img5',$fields,'water',$water_path);
		$this->logInsert = "添加信息: ".$fields['title'];
		$this->logUpdate = '更新信息: '.$fields['title'];
		return $fields;
	}


	/**
	 * [config config.php]
	 * @return [type] [提交过来的]
	 */
	public function config()
	{
		$fields=[];

		$fields['sitename']		=	I('post.sitename', '', 'trim');
		if($_SESSION['is_hidden']==true){
			$fields['isstate']	=	I('post.isstate', 0, 'intval');
			$fields['showinfo']	=	I('post.showinfo', '', 'trim,htmlspecialchars');
		}
		$fields['filetype']		=	I('post.filetype', '', 'trim,htmlspecialchars');
		$fields['filesize']		=	I('post.filesize', '', 'trim,htmlspecialchars');
		$fields['pictype']		=	I('post.pictype', '', 'trim,htmlspecialchars');
		$fields['picsize']		=	I('post.picsize', '', 'trim,htmlspecialchars');
		$fields['hotsearch']	=	I('post.hotsearch', '', 'trim,htmlspecialchars');
		$fields['seotitle']		=	I('post.seotitle', '', 'trim,htmlspecialchars');
		$fields['keywords']		=	I('post.keywords', '', 'trim,htmlspecialchars');
		$fields['description']  =	I('post.description', '', 'trim,htmlspecialchars');
		$fields['isrewrite']=0;//伪静态

		$fields['indexabout']	=	I('post.indexabout', '', 'trim,htmlspecialchars');
		$fields['indexcontact'] =	I('post.indexcontact', '', 'trim,htmlspecialchars');

		$fields['link1']		=	I('post.link1', '', 'trim,htmlspecialchars');#普通团车
		$fields['link2']		=	I('post.link2', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link3']		=	I('post.link3', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link4']		=	I('post.link4', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link5']		=	I('post.link5', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link6']		=	I('post.link6', '', 'trim,htmlspecialchars');#团子秒车
		#微信
		$fields['oauth']		=	I('post.oauth', '', 'trim,htmlspecialchars');#网页验证
		$fields['appid']		=	I('post.appid', '', 'trim,htmlspecialchars');#公众号id
		$fields['appsecret']	=	I('post.appsecret', '', 'trim,htmlspecialchars');#公众token

		$fields['email']		=	I('post.email', '', 'trim,htmlspecialchars');#邮箱
		$fields['tel']			=	I('post.tel', '', 'trim,htmlspecialchars');
		$fields['fax']			=	I('post.fax', '', 'trim');
		$fields['phone']		=	I('post.phone', '', 'trim,htmlspecialchars');
		$fields['address']		=	I('post.address', '', 'trim,htmlspecialchars');#地址
		$fields['siteurl']		=	I('post.siteurl', '', 'trim,htmlspecialchars');#pc端地址
		$fields['siteurl_wap']	=	I('post.siteurl_wap', '', 'trim,htmlspecialchars');#手机端地址
		$fields['webqq']		=	I('post.webqq', '', 'trim,htmlspecialchars');
		$fields['icpcode']		=	I('post.icpcode', '', 'trim,htmlspecialchars');//备案号
		//textarea
		$fields['header']     	=   I('post.header', '', '');//全局代码一般
		$fields['copyright']  	=   I('post.copyright', '', '');//版权信息 不做处理
		uppro('logo1', $fields, 'ajax');
		uppro('logo2', $fields, 'ajax');
		uppro('img1', $fields, 'ajax');
		uppro('file',$fields,'file');

		// $this->logInsert = '编辑系统信息';
		$this->logUpdate = '编辑系统信息';

		return $fields;
	}

	// content.php
	public function content()
	{
		$ty = I('post.ty',  0, 'intval');
		$fields = array(
			'pid'			=>	I('post.pid', 0, 'intval'),
			'ty'			=>	-$ty,
			'tty'			=>	I('post.tty', 0, 'intval'),
			'title'			=>	v_news_cats($ty,'catname'),
			'ftitle'		=>	I('post.ftitle',''),
			'name'   		=>	I('post.name',''),
			'content'		=>	I('post.content',''),
			'content2'		=>	I('post.content2',''),
			'content3'		=>	I('post.content3',''),
			'content4'		=>	I('post.content4',''),
			'content5'		=>	I('post.content5',''),
			'source'		=>	I('post.source',''),
			'linkurl'		=>	I('post.linkurl',''),
			'sendtime'		=>	I('post.sendtime',0,'strtotime'),
		);
		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		uppro('img3',$fields,'ajax');
		uppro('img4',$fields,'ajax');
		uppro('img5',$fields,'ajax');

		$this->logInsert = '添加单页->'.$fields['title'];
		$this->logUpdate = '编辑单页->'.$fields['title'];

		return $fields;
	}

	public function news_cats()
	{
		$fields=array(
			'pid' 		  => 		I('post.pid',0,'intval'),
			'catname'     => 		I('post.catname','','trim'),
			'catname2'    => 		I('post.catname2','','trim'),
			'tpl'         =>	    I('post.tpl','','trim'),
			'imgsize'     =>	 	I('post.imgsize','','trim'),
			'seotitle'    =>	 	I('post.seotitle','','trim'),
			'keywords'    =>	 	I('post.keywords','','trim'),
			'description' =>	 	I('post.description','','trim'),
			'linkurl'     =>	 	I('post.linkurl','','trim'),
			'contentTemplate'		=>	I('post.contentTemplate',''),
			'weblinkurl'  =>	 	I('post.weblinkurl','','trim'),
			'showtype'    =>	 	I('post.showtype',1,'intval'),
			'disorder'    =>	 	I('post.disorder',0,'intval'),
			'iscats'      =>	 	I('post.iscats',0,'intval'),
		);

		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		uppro('img3',$fields,'ajax');

		$this->logInsert = '添加栏目分类'.$fields['catname'];
		$this->logUpdate = '编辑栏目分类'.$fields['catname'];

		if ($this->isInsert) {
			$fields['isstate']=1;
			$fields['ishidden']=1;
		}

		return $fields;
	}

	public function pic()
	{
		$fields = array(
			'ti'			=>	I('post.ti',0,'intval'),
			'title'			=>	I('post.title',''),
			'content'			=>	I('post.content',''),
			'linkurl'		=>	I('post.linkurl','','trim,htmlspecialchars'),
			'sendtime'		=>	I('post.sendtime',0,'strtotime'),
		);
		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		$this->logInsert = '添加图片->'.$fields['title'];
		$this->logUpdate = '编辑图片->'.$fields['title'];
		return $fields;

	}

	//用户
	public function usr()
	{
		$fields = array(
			'state' => I('state', 0, 'intval'),
			'expired' => I('expired', time(), 'strtotime'),
		);
		$this->logInsert = '';
		$this->logUpdate = '用户修改';
		return $fields;

	}

	public function goods()
	{
		$fields = array(

			'goods_name' => I('post.goods_name', '', 'trim,htmlspecialchars'),//DEFAULT '' COMMENT '商品名称' ,
			'goods_name_added' => I('post.goods_name_added', '', 'trim,htmlspecialchars'),//DEFAULT '' COMMENT '商品名称' ,
			'category_id' => I('post.category_id', 0, 'intval'),//DEFAULT 0 COMMENT '商品分类id' ,
			'category_id_1' => I('post.category_id_1', 0, 'intval'),//DEFAULT 0 COMMENT '一级分类id' ,
			'category_id_2' => I('post.category_id_2', 0, 'intval'),//DEFAULT 0 COMMENT '二级分类id' ,
			'category_id_3' => I('post.category_id_3', 0, 'intval'),//DEFAULT 0 COMMENT '三级分类id' ,
			// 'group_id_array' => I('post.group_id_array', '', 'trim,htmlspecialchars'),//'店铺分类id 首尾用,隔开' ,
			'market_price' => I('post.market_price', '', 'trim,htmlspecialchars'),//DEFAULT 0.00 COMMENT '市场价' ,
			'price' => I('post.price', '', 'trim,htmlspecialchars'),//DEFAULT 0.00 COMMENT '商品原价格' ,
			// 'promotion_price' => I('post.promotion_price', '', 'trim,htmlspecialchars'),//DEFAULT 0.00 COMMENT '商品促销价格' ,
			'cost_price' => I('post.cost_price', '', 'trim,htmlspecialchars'),//DEFAULT 0.00 COMMENT '成本价' ,
			// 'shipping_fee' => I('post.shipping_fee', '', 'trim,htmlspecialchars'),//DEFAULT 0.00 COMMENT '运费 0为免运费' ,
			// 'shipping_fee_id' => I('post.shipping_fee_id', '', 'trim,htmlspecialchars'),//'售卖区域id 物流模板id  ns_order_shipping_fee 表id' ,
			'stock' => I('post.stock', 0, 'intval'),//DEFAULT 0 COMMENT '商品库存' ,
			// 'max_buy' => I('post.max_buy', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '限购 0 不限购' ,
			// 'hits' => I('post.hits', 0, 'intval'),//DEFAULT 0 COMMENT '商品点击数量' ,
			// 'min_stock_alarm' => I('post.min_stock_alarm', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '库存预警值' ,
			'sales' => I('post.sales', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '销售数量' ,
			'size' => I('post.size', '', 'trim,htmlspecialchars'),//DEFAULT '' COMMENT '规格' ,
			'collects' => I('post.collects', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '收藏数量' ,
			// 'star' => I('post.star', '', 'trim,htmlspecialchars'),//DEFAULT 5 COMMENT '好评星级' ,
			// 'evaluates' => I('post.evaluates', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '评价数' ,
			// 'shares' => I('post.shares', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '分享数' ,
			// 'picture' => I('post.picture', '', 'trim,htmlspecialchars'),
			// 'keywords' => I('post.keywords', '', 'trim,htmlspecialchars'),//DEFAULT '' COMMENT '商品关键词' ,
			// 'introduction' => I('post.introduction', '', 'htmlspecialchars'),//DEFAULT '' COMMENT '商品简介' ,
			'content' => I('post.content', '', 'htmlspecialchars'),//NOT NULL COMMENT '商品详情' ,
			// 'QRcode' => I('post.QRcode', '', 'trim,htmlspecialchars'),//DEFAULT '' COMMENT '商品二维码' ,
			// 'code' => I('post.code', '', 'trim,htmlspecialchars'),//DEFAULT '' COMMENT '商家编号' ,
			// 'is_stock_visible' => I('post.is_stock_visible', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '页面不显示库存' ,
			// 'is_hot' => I('post.is_hot', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '是否热销商品' ,
			// 'is_recommend' => I('post.is_recommend', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '是否推荐' ,
			// 'is_new' => I('post.is_new', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '是否新品' ,
			// 'is_pre' => I('post.is_pre', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '是否预售' ,
			// 'is_bill' => I('post.is_bill', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '是否开具增值税发票 1是，0否' ,
			'state' => I('post.state', 1, 'trim,htmlspecialchars'),//DEFAULT 1 COMMENT '商品状态 0下架，1正常，10违规（禁售）' ,
			'sale_date' => I('post.sale_date', '', 'trim,htmlspecialchars'),//  datetime NOT NULL COMMENT '上下架时间' ,
			'sendtime' => I('post.sendtime', time(), 'strtotime'),//datetime NOT NULL COMMENT '商品添加时间' ,
			'update_time' => I('post.update_time', date('Y-m-d H:i:s')),//DEFAULT NULL COMMENT '商品编辑时间' ,
			'disorder' => I('post.disorder', 0, 'intval'),//DEFAULT 0 COMMENT '排序' ,
			'real_sales' => I('post.real_sales', '', 'trim,htmlspecialchars'),//DEFAULT 0 COMMENT '实际销量' ,
		);
		if (!$fields['category_id_1'] || !$fields['category_id_2']) {
			ajaxReturn(-1,'请选择好一级类目及二级类目');
		}
		uppro('img1',$fields,'ajax');//DEFAULT 0 COMMENT '商品主图' ,
		// uppro('img5',$fields,'water',$water_path);
		$this->logInsert = "添加商品: ".$fields['goods_name'];
		$this->logUpdate = '更新商品: '.$fields['goods_name'];
		return $fields;
	}

}
