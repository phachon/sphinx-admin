<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Misc
 * @author: phachon@163.com
 */
class Misc {

	/**
	 * 转 utf8
	 * @param array $string
	 * @param string $fromEncoding
	 * @return array|string
	 */
	static public function toUTF8($string = array(), $fromEncoding = 'GBK') {
		if (is_array($string)) {
			foreach ($string as &$value) {
				self::toUTF8($value);
			}
		} else {
			$string = mb_convert_encoding($string, 'UTF8', $fromEncoding);
		}

		return $string;
	}
}