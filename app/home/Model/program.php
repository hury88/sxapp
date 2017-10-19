<?php
// $action = I('get.action', '', 'trim');
$ti = I('get.ti', 0, 'intval');
// $requestUri = '/program/index/ti=' . $ti;
list($display, $pagestr) = Program::_list($pid,$ty,$ti);
echo json_encode([$display, $pagestr]);
