<?php
class Showtype
{
	public static $classMap = [
		'1' => 'NewsList',
		'2' => 'SingleContent',
		'3' => 'PictureList',
		'4' => 'Friendlylinks',
		'5' => 'SingleInformation',
		'6' => 'CarouselPicture',
		// '7' => 'Message module',
		// '8' => 'FileDownload',
		'9' => 'ProductList',
		// '10'=> 'ProductClassification',
		// '11'=> 'TextList',
	];

	public static function dispatch($tpl='')
	{
		global $showtype,$pid,$ty;
		// $showtype = M('news_cats')->where("id=$ty")->getField('showtype');
		isset(self::$classMap[$showtype]) or die(config('r404'));
		$class = self::$classMap[$showtype];
		if ($showtype == 6) {
			return new V($pid,$ty,$tpl);
		} else {
			return new $class($pid,$ty);
		}
	}
}
