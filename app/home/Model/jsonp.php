<?php
$callback = $_GET['callback'];
switch($callback) {
	case 'productMasonryResult' : //产品瀑布流
	list($list, $lazyBtn, $lists) = ProductList::_list(2,-1);
	$json  = json_encode( ['html' => $lists, 'btn' => $lazyBtn] );
	break;
	case 'situationMasonryResult' : //产品瀑布流
	list($list, $lazyBtn, $lists) = SingleInformation::_list(3,-1);
	$json  = json_encode( ['html' => $lists, 'btn' => $lazyBtn] );
	break;
}
echo <<<EOF
$callback($json);
EOF;

/*
function giveMeMore(page) {
	var url = "/ModelJsonp/request/?page="+page+"&pid=<?php echo $pid ?>&callback=productMasonryResult";
	var script = document.createElement("script");
	script.setAttribute("src", url);
	document.getElementsByTagName("head")[0].appendChild(script);
}
 */
