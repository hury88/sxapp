<?php
// 单一内容
class SingleContent
{
	public function __construct($pid, $ty)
	{
		$content = v_news($pid, -$ty, 'content');
		$content or $content = config('other.nocontent');
		$this->pagestr = '';
		$this->display = <<<EOF
<div class="oneAll">
	$content
</div>
EOF;
	}

	public function __get($value)
	{
		return isset($this->$value) ? $this->$value : '';
	}
}
