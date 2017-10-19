<?php $view = View::index($id, $controller) ?>
<?php include DOCTYPE ?>
<?php include HEAD ?>
<?php if ($ty==17): //honor ?>
	<?php include HOME . 'public' .DS. 'honor' .EXT ?>
<?php elseif ($ty==19): //International cooperation ?>
	<?php include HOME . 'public' .DS. 'cooperation' .EXT ?>
<?php endif ?>
<?php include FOOT ?>