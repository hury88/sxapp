function _FUNCTION_()
{
	$li = '';
	$data = M('news')->field('title,isgood')->where(['pid'=>_PID_,'ty'=>_TY_,'isstate'=>1])->order('disorder desc,sendtime desc')->select();
	foreach ($data as $key => $value) {
		extract($value);
		$active = $isgood == 1 ? ' class="active"' : '';
		$li .= <<<T
<a$active href="/search/index?q=$title">$title</a>
T;
	}
	unset($data,$key,$value,$title);
	return $li;
}