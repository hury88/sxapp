<?php

	$path = dirname(__FILE__);
	@session_start();
	require($path.'/Common/Library/Verify.class.php');
	$Verify = new Verify();
	$Verify->entry(1);

 ?>