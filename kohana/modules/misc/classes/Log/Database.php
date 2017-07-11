<?php
/**
 * 异常日志
 * @author phachon@163.com
 */
class Log_Database extends Log_Writer {

	protected $_db = 'sphinx';

	protected $_table = 'log_crash';

	public function __construct() {}

	/**
	 * 重写write
	 * @param  array  $messages
	 */
	public function write(array $messages) {

		foreach ($messages as $message) {
			$this->_write($message);
		}
	}

	/**
	 * 写入
	 * @param array $message
	 * @return object
	 */
	public function _write(array $message) {

		$values = array (
			'level' => $message['level'],
			'ip' => isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : '',
			'hostname' => isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : '',
			'file' => $message['file'],
			'line' => $message['line'],
			'message' => $message['body'],
			'create_time' => $message['time'],
		);

		if(isset($message['additional']['exception'])) {
			if($values['file'] === NULL) {
				$values['file'] = $message['additional']['exception']->getFile();
			}
			if($values['line'] === NULL) {
				$values['line'] = $message['additional']['exception']->getLine();
			}
		}

		return DB::insert($this->_table)
			->columns(array_keys($values))
			->values(array_values($values))
			->execute($this->_db);
	}
}