<?php
if ( function_exists('ini_get') ) {
$onoff = ini_get('register_globals');
} else {
$onoff = get_cfg_var('register_globals');
}
if ($onoff != 1) {
@extract($HTTP_SERVER_VARS, EXTR_SKIP);
@extract($HTTP_COOKIE_VARS, EXTR_SKIP);
@extract($HTTP_POST_FILES, EXTR_SKIP);
@extract($HTTP_POST_VARS, EXTR_SKIP);
@extract($HTTP_GET_VARS, EXTR_SKIP);
@extract($HTTP_ENV_VARS, EXTR_SKIP);
}

session_start();
session_unset();
echo "<script>location.href='index.php';</script>";
?>
