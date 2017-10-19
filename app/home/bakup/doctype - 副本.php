<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $system_seotitle ?></title>
	<meta name="keywords" content="<?php echo $system_keywords?>">
	<meta name="description" content="<?php echo $system_description?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="/style/css/bootstrap.css">
	<link rel="stylesheet" href="/style/css/style.css?v=1.2012+5">
</head>
<body>
	<?php config('pcBread', pc_bread($q,$pid,$ty,$tty,$id) ) ?>