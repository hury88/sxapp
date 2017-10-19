<?php
// $action = I('get.action', '', 'trim');
// $ti = I('get.ti', 0, 'intval');
// $requestUri = '/program/index/ti=' . $ti;
list($display, $pagestr) = $controller::_list($pid,$ty);
echo json_encode([$display, $pagestr]);
