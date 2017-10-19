<?php
class MsgBox
{
	const TABLE = 'message_box';

	public function __construct()
	{
	}

	// add(['title','source','msg'], 12);
	public static function add($msg = [],$uid=0){
		$msg = [
			'title' => $msg[0],
			'source' => $msg[1],
			'msg' => $msg[2],
			'uid' => $uid,
			'sendtime' => time(),
		];
		return self::insert($msg);
	}

	// 已阅读
	public static function read($id){
		return self::update(['isread' => 1], "id=$id");
	}
	// 系统的消息已阅读
	public static function readSystem($id, $sysid){
		$data = [
			'mbid' => $mbid,
			'sysid' => $sysid,
		];
		if (self::find($data)) {
			return false;
		} else {
			return self::insert($datga);
		}
	}

	//系统消息显示
	public static function getDataCount($uid)
	{

		$msgBoxModel = M(self::TABLE);
		$regtime = M(User::TABLE)->where(['id'=>$uid])->getField('regtime');
		$ownMsgCount = $msgBoxModel->where("(uid = $uid or (uid=-1 and isstate=1 and sendtime >= $regtime) )and isread=0")->count(); $ownMsgCount or $ownMsgCount = 0;

		return ($ownMsgCount);
	}
	//系统消息显示
	public static function getData($uid)
	{

		$msgBoxModel = M(self::TABLE);
		$regtime = M(User::TABLE)->where(['id'=>$uid])->getField('regtime');
		// $ownMsg = $msgBoxModel->where(['uid'=>$uid])->order('sendtime desc')->select();
		// $sysMsg = $msgBoxModel->where('uid=-1 and isstate=1 and sendtime >= ' . $regtime)->order('sendtime desc')->select();
		// $msgs = $msgBoxModel->where("uid = $uid or (uid=-1 and isstate=1 and sendtime >= $regtime)")->order('sendtime desc')->select();

		$where = "uid = $uid or (uid=-1 and isstate=1 and sendtime >= $regtime)";


		$pageConfig = array(
		        'where' => $where,//条件
		        'order' => 'sendtime desc',//排序
		        'psize' => '12',//条数
		        'table' => self::TABLE,//表
		        'field' => '*',//表
		        'style' => 'href',
		        );
		// $pageConfig = array_merge($pageConfig, $config);
		return Page::paging($pageConfig,'show_front_mvc_pc');
/*
		$orders = M(Order::TABLE)->field('city,brandid,starttime,endtime')->where($where)->group('city,brandid')->select();
	  // dump($sysMsg);
		$brandids = $brandend = array();
		$tools = import('Tools');
		foreach ($orders as $key => $value) {
			$tools->set($value['brandid'],$value['city']);

			array_push($brandids, $tools->cityInfo['id']);
			array_push($brandend, $tools->cityInfo['end']);
		}
		reset($orders);
	  $brandids = implode(',', $brandids);//收集订单品牌号
	  // ECHo $brandids;
	  $brandMsg = $msgBoxModel->alias('l1')->where('uid=-1 and isstate=1 and brandid in('.$brandids.')')->order('sendtime desc')->select();

	  foreach ($brandMsg as $key => $value) {
	  	foreach ($brandend as $key2 => $endtime) {
	  		if($endtime > $value['sendtime']){
	  			array_push($ownMsg,$value);break;
	  		}
	  	}

	  }*/
	  UNSET($sysMsg,$key,$value,$brandids,$brandend,$orders);
	  return $ownMsg;
	}

	public static function insert($data)
	{
		return M(self::TABLE)->insert($data);
	}

	public static function find($where)
	{
		return M(self::TABLE)->where($where)->find();
	}

	public static function update($data, $where='')
	{
		return M(self::TABLE)->where($where)->update($data);
	}
}