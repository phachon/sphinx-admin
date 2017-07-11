<?php
/**
 * 日志操作
 * @author: panchao
 */
class Logger {

	const LOGGER_INFO = 1;
	const LOGGER_SUCCESS = 2;
	const LOGGER_ERROR = 3;

	/**
	 * info log
	 * @param string $message
	 * @param mixed $data
	 */
	public static function info($message, $data = '') {
		self::write(SUCCESS_LOG, $message, $data);
	}

	/**
	 * error log
	 * @param string $message
	 * @param mixed $data
	 */
	public static function error($message, $data = '') {
		self::write(ERROR_LOG, $message, $data);
	}

	/**
	 * execute write
	 * @param string $file
	 * @param string $message
	 * @param mixed $data
	 */
	public static function write($file, $message, $data) {
		if(is_array($data)) {
			$data = json_encode($data);
		}
		$dataFormat = date('Y-m-d h:i:s');
		file_put_contents($file, "[{$dataFormat}]: ".$message .' '. $data."\r\n", FILE_APPEND);
	}
}