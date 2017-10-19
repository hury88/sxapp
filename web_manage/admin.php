<?php
require 'include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
</head>
<frameset rows="88,*" border="0">
	<frame src="headers.php" frameborder="0" scrolling="no" name="tophtml" noresize="noresize" />
    <frameset  cols="187,*" border="0">
    	<frame src="lefts.php" frameborder="0" scrolling="auto" name="lefthtml" />
        <frame src="mains.php" frameborder="0" scrolling="auto" name="righthtml" />
    </frameset>
</frameset><noframes></noframes>