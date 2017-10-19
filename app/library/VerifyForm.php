<?php
class VerifyForm
{
	private static $input = [];
	private $result = false;
	public $error  = '';

	public function __construct($verifyFields, $request='post')
	{
		self::input($request);
		$this->result = $this->parseError($verifyFields);
	}

	public function data()
	{
		return self::$input;
	}

	//自定义
	public function result()
	{
		$result = $this->result;
		if ($result) {
			$this->field = $result[0];
			$this->error = $result[1];
			return true;
		}
		return false;
	}

	private static $regData = [
		'email' => '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/',
		'password' => '/^.{8,20}$/',
		'telphone' => '/^1[34578]{1}[0-9]{9}$/',
	];


	public function parseError($verifyFields)
	{
		$verifyFields = (array) $verifyFields;
		foreach ($verifyFields as $field => $arr) {
			$func = $arr[0];
			//指定函数传入额外参数
			if (strpos($func, '.')) {
				list($func, $arg) = explode('.', $func, 2);
				$result = $this->$func($field, $arg);
			} else {
				$result = $this->$func($field);
			}
			if (! $result) {
				return [$field, $arr[1]];
			};
		}
		return false;

	}

	public static function input($required, $data = [])
	{
		switch ($required) {
			case 'post':
				$input = &$_POST;
				break;
			case 'get':
				$input = &$_GET;
			case 'put':
	            parse_str(file_get_contents('php://input'), $input);
			case 'data':
				$input = $data;
	            break;
		}
		// array_walk($input, 'array_walk_decode');
		self::$input = $input;
	}

	private function need($f)
	{
		$f = $this->$f;
		$this->$f = trim(htmlspecialchars($f));
		return true;
	}

	private function required($f)
	{
		$f = $this->$f;
		if ($f) {
			$this->$f = trim(htmlspecialchars($f));
			return true;
		} else {
			return false;
		}
	}

	private function password($f)
	{
		$f = $this->$f;
		if ($f) {
			$this->$f = $f;
			return preg_match(self::$regData['password'], $this->$f);
			// return true;
		} else {
			return false;
		}
	}

	private function inted($f)
	{
		$f = intval($this->$f);
		if ($f) {
			$this->$f = $f;
			return true;
		} else {
			return false;
		}
	}


	private function equal($f, $g)
	{
		$f = $this->$f;
		$g = $this->$g;
		if ($f == $g) {
			return true;
		} else {
			return false;
		}
	}



	private function email($f)
	{
		return preg_match(self::$regData['email'], $this->$f);
	}

	private function telphone($f)
	{
		return preg_match(self::$regData['telphone'], $this->$f);
	}

	public function time()
	{
		if ($this->_time) {
			return $this->_time;
		} else {
			return $this->_time = time();
		}
	}

	public static function md5($word, $sign='')
	{
		return md5(md5($word) . $sign);
	}

	public function ip()
	{
		return Request::instance()->ip();
	}



	public function __call($pattern,$args)
	{
		$f = $args[0];
		$f = $this->$f;
		if ($f) {
			return preg_match($pattern, $f);
		} else {
			return false;
		}
	}

	public function __get($key)
	{
		return isset(self::$input[$key]) ? self::$input[$key] : '';
	}

	public function __set($key, $value)
	{
		self::$input[$key] = $value;
	}
}

