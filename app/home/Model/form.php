<?php
// $action = I('get.action', '', 'trim');
// echo $_SESSION['csrf'];
/*if (! Csrf::verify()) {
  header("HTTP/1.1 404 Not Found");
  die('HTTP/1.1 404 Not Found');
}*/

// $_POST = $_GET;
$method = I('get.action', 'index', 'trim');
if (method_exists('Message', $method)) {
	$obj = new Message;
	$obj->$method();
} else {
	die('HTTP/1.1 404 Not Found');
}

