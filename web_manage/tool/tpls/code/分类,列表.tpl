function _FUNCTION_()
{
	$list='';
	$smallGame = I('get.smallGame', 0, 'intval');

	$link = U('moban/index', ['smallGame'=>$smallGame]);

	$data = M('news')->where(['pid'=>_PID_,'ty'=>_TY_,'isstate'=>1])->order(config('other.order'))->getField('id,title');
	foreach($data as $id => $title) {
		$on = $id == $smallGame ? ' class="active"' : '';
		$url = U('moban/index', ['smallGame'=>$id]);
		$list .= <<<T
<a href="$url" $on>$title</a>
T;
	}
	unset($pid,$ty,$row,$tpl,$data,$id,$title);
	return [$list, $link];

}