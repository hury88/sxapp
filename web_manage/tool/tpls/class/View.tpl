<?php
class View
{
	public static $data = [];// 当前类型信息
	public $error = false;

	public function __construct($id, $table)
	{
		if($id) {
			if ($data = M($table)->find($id)) {
				self::data($data);
			} else {
				$this->error = true;
			}
		} else {
			$this->error = true;
		}
	}

	public static function index($id, $controller)
	{
		$tabalModel = M($table = 'news');
		$redirect_url = U($controller);
		$view = new View($id, $table);
		if ($view->error) {
			header('location:' . $redirect_url);
		}
		$id = $view->id;
		$tabalModel->where("`id`=$id")->setInc('hits');

		$pid = $view->pid;
		$ty = $view->ty;
		$view->time = date('Y-m-d', $view->sendtime);
		$view->content = htmlspecialchars_decode($view->content);
		$view->back = U($view->pid,['ty'=>$view->ty]);

		#######上一篇下一篇 开始
		$prevOneNext = $tabalModel->field('id,title')->where("`pid`=$pid AND `ty`=$ty AND isstate=1")->order(Config::get('order.order'))->select();
		$view->PreviousNext($prevOneNext,$id,$controller);
		unset($prevOneNext);
		#######上一篇下一篇 结束

		return $view;
	}

	public function PreviousNext($data,$id,$controller)
	{
		foreach ($data as $key => $row) {
		  if ($row['id']==$id) {
		    $previous = isset($data[$key-1]) ? $data[$key-1] : false;
		    $next = isset($data[$key+1]) ? $data[$key+1] : false;
		  }
		}
		$tpl_previous = '<li>上一篇：<a href="%s">%s</a></li>';
		$tpl_next = '<li>下一篇：<a href="%s">%s</a></li>';
		if($previous){
		  $url = U("$controller/detail", ['id'=>$previous['id']]);
		  $title = $previous['title'];
		}else{
		  $url = 'javascript:void(0);';
		  $title = '已经是第一篇';
		}
		$this->previous = sprintf($tpl_previous,$url,$title);
		//下一个
		if($next){
		  $url = U("$controller/detail", ['id'=>$next['id']]);
		  $title = $next['title'];
		}else{
		  $url = 'javascript:void(0);';
		  $title = '没有了';
		}
		$this->next = sprintf($tpl_next,$url,$title);
		unset($previous,$next,$tpl_previous,$tpl_next,$url,$title);
	}


	public function init()
	{
		self::data(M($table)->find($this->id));
	}

	public static function data($data)
	{
		array_walk($data, 'array_walk_decode');
		self::$data = array_merge(self::$data, $data);
		return self::$data;
	}

	public function __get($key)
	{
		return isset(self::$data[$key]) ? htmlspecialchars_decode( self::$data[$key] ) : '';
	}

	public function __set($key, $value)
	{
		self::$data[$key] = $value;
	}
}




