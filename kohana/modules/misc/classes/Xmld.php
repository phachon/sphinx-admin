<?php
/**
 * xml 操作
 * @author: phachon@163.com
 */
class Xmld {

	/**
	 * array 转换成 xml
	 * @param array $data
	 * @return mixed
	 */
	public static function arrayToXml(array $data = []) {
		$string = "<?xml version='1.0' encoding='utf-8'?><document>";
		$string = self::_createItem($string, $data);
		$string .= "</document>";

		$xml = simplexml_load_string($string);
		return $xml->asXML();
	}
	
	private static function _createItem($string, array $data) {
		foreach($data as $key => $value) {
			if(is_numeric($key)) $key = "item";
			if(is_array($value)) {
				$string .= "<{$key}>";
				$string = self::_createItem($string, $value);
				$string .= "</{$key}>";
			} else {
				$string .= "<{$key}>{$value}</{$key}>";
			}
		}
		return $string;
	}

}