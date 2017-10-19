<?php
// error_reporting(E_ALL);
/*define('IN_COPY',true);
include_once dirname(dirname(dirname(__FILE__)))."/functions.php";*/
// include_once dirname(dirname(dirname(__FILE__)))."/Common/functions.php";
  /*require_once "php/jssdk.php";
  $jssdk = new JSSDK('wxfa48c47f9b1a3ef6', '60bfa8be10f8953f8f5177c4cdc10eaf');
  $AT = $jssdk->getAccessToken();
	$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$AT;
	$result = CURLSend($url,'post',$josn);var_dump($result);*/
class wechat{

	public static $ARR = array();
	public static $jssdk = null;

	const TOKEN = 'hury88';/*加密所用的*/


	public function __construct(){
		include_once dirname(dirname(dirname(dirname(__FILE__))))."/wap/php/jssdk.php";
		$config  = M('config')->field('appid,appsecret')->find();
		wechat::$jssdk = new JSSDK($config['appid'], $config['appsecret']);
		UNSET($config);
	}

	public function getAccessToken(){
		return wechat::$jssdk->getAccessToken();
	}

	/**
	 * [__construct 回复信息]
	 * @param [type] $ToUserName   [接受方账号 OppenId]
	 * @param [type] $FromUserName [开发者微信号]
	 * @param [type] $data         [description]
	 * @param [type] $MsgType      [用户回复消息类型]
	 */
	private function replyBody($ToUserName, $FromUserName, $Main, $MsgType){
		$CreateTime  = time();
		//不要留空格
		$replyMsg =
<<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
%s
</xml>
XML;
		return sprintf($replyMsg,$ToUserName,$FromUserName,$CreateTime,$MsgType,$Main);

	}

	/**
	 * [responseMsg 响应信息]
	 * @echo [type] [我们的回复]
	 */
	public function responseMsg(){
		//接受xml格式的消息(未加密)
		// 方式2 : $xmlstr = $GLOBALS('HTTP_RAW_POST_DATA');
		$xmlstr = file_get_contents('php://input');//(未加密)
		$xmlobj = simplexml_load_string($xmlstr,'SimpleXMLElement',LIBXML_NOCDATA);
		//消息类型分离
		if(!is_object($xmlobj))return false;
		$msgType = trim($xmlobj->MsgType);
		switch ($msgType) {
			#事件推送
			case 'event':
				$result = $this->receiveEvent($xmlobj);
				break;
			#普通消息
			case 'text'://普通文本消息
				// $result = $this->receiveText($xmlobj);
				$result = $this->transmitService($xmlobj);
				break;
		}
		echo $result;
	}

	/**
	 * [receiveEvent 事件推送后的回调]
	 * @param  [type] $xmlobj [description]
	 * @return [type]         [description]
	 */
	private function receiveEvent($xmlobj){
		$event = trim($xmlobj->Event);
		switch ($event) {
			case 'subscribe':
				$text = $this->receiveText($xmlobj,'谢谢,关注');
				break;

			case 'unsubscribe':
				# code...
				break;

			default:
				// $text = $this->receiveText($xmlobj,'这是'.$event.'事件');
				$text = $this->receiveText($xmlobj,'请发送您想要咨询的品牌');
				break;
		}
		return $text;

	}

	/**
	 * [receiveText 普通文本消息的回复]
	 * @param  [type] $xmlobj [description]
	 * @return [type]         [description]
	 */
	private function receiveText($xmlobj,$RT=''){
		if($RT==''){
			$RT = $this->RT($xmlobj);
		}
		$main = '<Content><![CDATA['.$RT.']]></Content>';
		//调用回复体模板
		//注意这里的 to 和 from 对象
		$replyMsg = $this->replyBody($xmlobj->FromUserName, $xmlobj->ToUserName, $main, 'text');
		return $replyMsg;
	}
	/**
	 * receiveText 消息回复的具体实现
	 * @param unknown $xmlobj
	 * @return string
	 */
	private function RT($xmlobj){
		$content = $xmlobj->Content;
		if( $this->findKey($content,array('time','时间')) ){
			//查询时间
			$text = '现在的时间是 : '.date('Y-m-d h:i:s');
		}elseif( $this->findKey($content,array('谢谢','thanks')) ){
			$text = '这是自动回复';
		}elseif($city=strstr($content,'天气 ')){
			$city = end(explode(' ',$city));
			$text = $this->getWeather($city);
		}elseif( $this->findKey($content,array('天气','查询','wether','气候')) ){
			$text = '查询天气 请按照 (天气 XX) 格式 ,如要查询合肥天气,请输入:天气 合肥';
		}else{
			$text = '消息已收到';
			//转发给客服
			$text = $this->kf_isstatus(1);

			// $text = $this->transmitService($xmlobj);
			// $this->log($text);
		}
		return $text;
	}

	/**
	 * [toCustomerCare 将客户的消息转发给多客服]
	 * @param  [type] $xmlobj [已解析的消息体]
	 * @return [type]         []
	 */
	private function toCustomerCare($xmlobj){
		$MsgType = 'transfer_customer_service';//转发给的多客服的消息类型
		// $main = '<TransInfo><KfAccount><![CDATA['.$RT.']]></KfAccount></TransInfo>';//指定客服
		$time = time();
		$replyMsg =
<<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>
XML;
		// $replyMsg = $this->replyBody($xmlobj->FromUserName, $xmlobj->ToUserName, '', $MsgType);
		$replyMsg = sprintf($replyMsg,$xmlobj->ToUserName, $xmlobj->FromUserName, $time);
		return $replyMsg;
	}

	private function transmitService($object)
	    {
		// 2017年5月3日10:18:07  增加客服自动接入功能
		$userInfo = $object->Content;//用户消息
		// $result = M('kf')->where(array('brand'=>array('like',"%$userInfo%")))->order('kfid desc')->find();
		// $this->kf_isstatus($kf_isstatus);
		/*if( $return ){//找到了
		}*/
		$kfSet = $this->kf_online($userInfo);//在线客服集合信息
		$this_kf = '';//指定客服
		if ($kfSet) {
			$kfFirst = array_shift($kfSet);
			$this_kf =
					'<TransInfo>
				         <KfAccount><![CDATA['.$kfFirst['kfaccount'].']]></KfAccount>
				     </TransInfo>';
		}
	        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[transfer_customer_service]]></MsgType>
						%THISKF%
						</xml>";
			$xmlTpl = str_replace('%THISKF%',$this_kf,$xmlTpl);
			$this->log($xmlTpl);
	        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
	        return $result;
	    }

	private function kf_online($brandName)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token='.$this->getAccessToken();
		$data = json_decode(CURLSend($url,'get'),true);
		$data = current($data);
		$kfids = array();
		foreach ($data as $key => $value) {//接口返回值提取在线客服工号
			array_push($kfids,$value['kf_id']);
		}
		$map = array(
			'kfid' => array('in',$kfids),
			'brand' => array('like',"%$brandName%"),
			// 'brand' => array$brandName,
		);
		$kfs = M('kf')->where($map)->order('kfid desc')->select();//获取在线客服 服务的品牌
		return $kfs ? $kfs : array();
	}


	/**
	 * [getWeather 天气接口]
	 * @param  [type] $cityname [城市中文名称]
	 * @return [type]           [天气信息]
	 */
	private function getWeather($cityname){
		$gb_cityname = iconv('utf-8','gb2312',$cityname);
		//使用天气接口
		$url = 'http://php.weather.sina.com.cn/xml.php?city=%s&password=DJOYnieT8234jlsK&day=0';
		$weather = CURLSend(sprintf($url,$gb_cityname));
		$sky = simplexml_load_string($weather);
		$sky = $sky->Weather;
		$cstr = '当前实况消息(%DATE%):%CITY% %STATUS% 白天: %TEMPERATURE1%℃ 晚上:%TEMPERATURE2%℃ %DIRECTION% %POWER%级 适宜穿:%CHY_SHUOMING%   温馨提示 : %REMAIN%';
		$weather_str = str_replace(
				array('%DATE%','%CITY%','%STATUS%','%TEMPERATURE1%','%TEMPERATURE2%','%DIRECTION%','%POWER%','%CHY_SHUOMING%','%REMAIN%'),
				array($sky->udatetime,$sky->city,$sky->status1,$sky->temperature1,$sky->temperature2,$sky->direction2,$sky->power1,$sky->chy_shuoming,$sky->ssd_s.PHP_EOL.$sky->gm_s),
				$cstr);
		return $weather_str;
	}


	/**
	 * [findKey 查找一段文本中是否存在关键字]
	 * @return [type]           [true存在,false不在]
	 */
	private function findKey($haystack,$need){
		foreach ($need as $keyword) {
			$pos = stripos($haystack,$keyword);
			if($pos === false){
				continue;
			}else{
				return true;
			}
		};return false;
	}


	/**
	 * [valid 验证Token]
	 * 在接受方式为GET的情况下 调用
	 * @echo [type] [响应随机字符串]
	 */
	public function valid(){
		$signature =  $_GET['signature'];//微信加密签名
		$timestamp =  $_GET['timestamp'];//时间戳
		$nonce     =  $_GET['nonce']	;//随机数
		$echostr   =  $_GET['echostr']  ;//随机字符串

		#* 1. 将token、timestamp、nonce三个参数进行字典序排序
		$token = 'shangtuan';
		$tempArr = array( $timestamp, $nonce, $token);
		sort($tempArr);
		#* 2. 将数组拼接成一个字符串进行sha1加密
		$tempStr = implode( $tempArr );
		$tempStr = sha1( $tempStr );

		$result =  $tempStr == $signature ? $echostr : '验证失败';
		#* 3. 加密后的字符串可与signature对比，标识该请求来源于微信
		{//开启调试
			$str = "\n\nREMOTE_ADDR:".$_SERVER["REMOTE_ADDR"];
			$str .= strstr($_SERVER["REMOTE_ADDR"],'101.226')? "FROM WeiXin":"Unknown IP";
			$str .= "QUERY_STRING:".$_SERVER["QUERY_STRING"].PHP_EOL.$result;
			file_put_contents('00.log', $str,FILE_APPEND);

		}
		ECHO $result;
		exit;
	}

	private function log($content){
		file_put_contents('00.log', $content.PHP_EOL,FILE_APPEND);

	}

	private function checkSignature()
	   {
	       $signature = $_GET["signature"];
	       $timestamp = $_GET["timestamp"];
	       $nonce = $_GET["nonce"];

	       $token = TOKEN;
	       $tmpArr = array($token, $timestamp, $nonce);
	       sort($tmpArr);
	       $tmpStr = implode( $tmpArr );
	       $tmpStr = sha1( $tmpStr );

	       if( $tmpStr == $signature ){
	           return true;
	       }else{
	           return false;
	       }
	   }




	/**
	 * [CURLSend 使用curl向服务器传输数据]
	 * @param [type] $url  [请求的地址]
	 * @param array  $data [数据]
	 * @param string $type [请求方式GET,POST]
	 */
	function CURLSend($url, $method='get', $data=array()) {
		$data = http_build_query($data);

		$ch = curl_init();//初始化
		$headers = array('Accept-Charset: utf-8');
		//设置URL和相应的选项
		curl_setopt($ch, CURLOPT_URL, $url);//指定请求的URL
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));//提交方式
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//不验证SSL
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//不验证SSL
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置HTTP头字段的数组
		// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible;MSIE 5.01;Windows NT 5.0)');//头的字符串
		#curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
		#curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);//自动设置header中的Referer:信息
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//提交数值
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//是否输出到屏幕上,true不直接输出
		$temp = curl_exec($ch);//执行并获取结果
		curl_close($ch);
		return $temp;//return 返回值
	}

































	//回复消息 格式 封装

	 /* 回复消息格式 封装函数
	 * $ToUserName //接收方帐号（收到的OpenID）
	 * $FromUserName //开发者微信号
	 * $data //需要回复的消息
	 * $type //消息类型
	 *  */
	private function _____replyMsg($ToUserName, $FromUserName, $data, $type) {

	    //回复消息的基本格式
	    $arr = array(
	        'ToUserName' => $ToUserName,
	        'FromUserName' => $FromUserName,
	        'CreateTime' => time(),
	        'MsgType' => $type,
	    );
	    if ($type == 'text') {//文本消息
	        $arr['Content'] = htmlspecialchars_decode($data);
	    } elseif ($type == 'news') {//多图文消息
	        $arr['ArticleCount'] = count($data);
	        $arr['Articles'] = $data;
	    }
	    $xml = new SimpleXMLElement('<xml></xml>'); //实例化XML
	    data2xml($xml, $arr); //调用数组转换为XML函数
	    exit($xml->asXML()); //结束输出xml
	}

	/*
	 * 数组转XML
	 * 使用递归的方式对数组降维
	 */
	private function data2xml($xml, $data) {
	    foreach ($data as $key => $value) {//遍历数组
	        is_numeric($key) && $key = 'item'; //把下标为数字的 变为字符串
	        if (is_array($value)) {//判断是否为数组，是数组使用递归继续遍历数组
	            $child = $xml->addChild($key); //添加一个子元素
	            data2xml($child, $value); //递归
	        } else {
	            if (is_numeric($value)) {//键值是数字，
	                $child = $xml->addChild($key, $value); //数组中键和值添加一个子元素
	            } else {
	                $child = $xml->addChild($key); //添加一个子元素
	                $node = dom_import_simplexml($child); //从内存中获取到DOM simplexml 节点(子元素)
	                $node->appendChild($node->ownerDocument->createCDATASection($value)); //把字符串的键值 添加"<![CDATA[值]]>"格式,在追加到 子元素中
	            }
	        }
	    }
	}


	/**
	 * [parseXML 将xml对象解析成数组,如果xml是字符串则先转换成xml对象]
	 * @param  [type] $xml [xml对象或者xml标签]
	 * @return [type]      [返回转换后的数组]
	 */
	public function parseXML($xml,$xml2arr=array()){
		if( is_string($xml) ){
			$xml = new SimpleXMLElement($xml);
		}
		foreach ($xml as $key => $value) {
			$xml2arr[$key] = (string)$value;
		};return $xml2arr;
	}



}