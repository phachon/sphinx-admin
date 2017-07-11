<?php
/**
 * 杂项
 * @author: phachon@163.com
 */
class Misc {

	/**
	 * 获取客户端 ip
	 * @return int|mixed
	 */
	static public function getClientIp() {
		$ip = 0;
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
			$forwarded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = array_shift($forwarded);
		} else if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			if (!empty($_SERVER['REMOTE_ADDR'])) {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		}
		return $ip;
	}


}