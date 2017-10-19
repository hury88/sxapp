<?php

  	$view = View::index($id, $controller);
  	include DOCTYPE;
echo   	<<<EOF
<link rel="stylesheet" type="text/css" href="/style/css/a.style.css.pagespeed.cf.yqgeohotqs.css">
<script type="text/javascript" language="javascript" src="/style/js/rem.js"></script>
<script src="/style/js/jquery.min.js"></script>
<script src="/style/js/touchslide.js"></script><script>eval(mod_pagespeed_pQEkTQ\$aCs);</script>
EOF;
  	include HEAD;
  	include HOME . 'public' .DS. 'product' .EXT;
  	include FOOT;

 ?>