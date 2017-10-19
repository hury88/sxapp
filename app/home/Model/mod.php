<?php
$class = ucfirst($controller);
if (class_exists($class) && method_exists($class, $method)) {
	$class = new $class;
	echo json_encode( call_user_func_array([$class,$method], []) );
} else {
  die(config('r404'));
}
