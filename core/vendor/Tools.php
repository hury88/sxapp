<?php
/**
 * 工具类
 */
class Tools
{
	/**
	 * [toPercentage 将数字转换成百分比的形式]
	 * @param  [type]  $dividend [被除数]
	 * @param  [type]  $divisor  [除数]
	 * @param  integer $floating [小数点后保留位数]
	 * @return [type]            [50.00%]
	 */
	public static function toPercentage($dividend, $divisor = 0, $floating = 2)
	{
		#除数不能为0
		if (0 == $divisor) {
			return sprintf('%4.' . $floating . 'f%%', $dividend * 100 );
		} else {
			return sprintf('%4.' . $floating . 'f%%', ($dividend / $divisor) * 100 );
		}
	}

	/**
	 * [keepDecimal 保留几位小数]
	 * @param  [type]  $number   [数字]
	 * @param  integer $floating [小数点后几位]
	 */
	public static function keepDecimal($number, $floating = 2)
	{
		return sprintf('%.' . $floating . 'f', $number);
	}
	/**
	 * [keepDecimal 保留几位小数]
	 * @param  [type]  $number   [数字]
	 * @param  integer $floating [小数点后几位]
	 */
	public static function toFixed($number, $floating = 2)
	{
		return sprintf('%.' . $floating . 'f', $number);
	}

}