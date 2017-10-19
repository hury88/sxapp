<?php
$id = I('get.id', 0, 'intval');
$action = I('get.action', '', 'trim');

switch ($action) {
  case 'increase':
      M('news')->where("`id`=$id")->setInc('hits');
    break;
  default:
      $hits = M('news')->where("`id`=$id")->getField('hits');
      die('document.write('.$hits.')');
    break;
}
// <script type="text/javascript" src="/ModelCount/?action=increase&id=<?php echo $view->id "></script>
