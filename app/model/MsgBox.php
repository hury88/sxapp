<?php
class MsgBox
{
	const TABLE = 'message_box';

	public function __construct()
	{
	}

	// add(['title','source','msg'], 12);
	public static function add($title,$msg,$uid=0){
		$msg = [
			'title' => $title,
			'source' => '',
			'msg' => $msg,
			'uid' => $uid,
			'sendtime' => time(),
		];
		return self::insert($msg);
	}

	// 已阅读
	public static function read($id){
		return self::update(['isread' => 1], "id=$id");
	}
	// 已阅读
	public static function clear($uid){
		return self::update(['isstate' => 0], "uid=$uid");
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
	public static function getDataCount($uid, $regtime)
	{

		$msgBoxModel = M(self::TABLE);
		$ownMsgCount = $msgBoxModel->where("(uid = $uid or (uid=-1 and isstate=1 and sendtime >= $regtime) )and isread=0")->count(); $ownMsgCount or $ownMsgCount = 0;
		return ($ownMsgCount);
	}
	//系统消息显示
	public static function getData($uid, $regtime)
	{
		try {
			$msgBoxModel = M(self::TABLE);
			$where = "(uid = $uid or (uid=-1 and sendtime >= $regtime)) and isstate=1";
			$res = $msgBoxModel->where($where)->order('sendtime desc')->select();
			return $res?:[];
		} catch (Exception $e) {
			return [];
		}

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