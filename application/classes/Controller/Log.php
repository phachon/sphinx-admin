<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 账号管理
 * @author phachon@163.com
 */
class Controller_Log extends Controller_Render {

	protected $_default = 'layouts/log';

	/**
	 * index
	 */
	public function action_index() {
		Controller::redirect('log/list');
	}

	/**
	 * 日志列表
	 */
	public function action_list() {

		$keyword = Arr::get($_GET, 'keyword', '');
		if($keyword) {
			$total = Business::factory('Log')->countLogsByKeyword($keyword);
			$paginate = Paginate::factory($total);
			$logs = Business::factory('Log')->getLogsByLimitAndKeyword($keyword, $paginate->offset(), $paginate->number());
		} else {
			$total = Business::factory('Log')->countLogs();
			$paginate = Paginate::factory($total);
			$logs = Business::factory('Log')->getLogsByLimit($paginate->offset(), $paginate->number());
		}
		$this->_default->content = View::factory('log/list')
			->set('logs', $logs)
			->set('pagination', $paginate);

	}

	/**
	 * 异常日志
	 */
	public function action_crash() {

		$keyword = Arr::get($_GET, 'keyword', '');
		if($keyword) {
			$total = Business::factory('Log')->countCrashLogsByKeyword($keyword);
			$paginate = Paginate::factory($total);
			$crashLogs = Business::factory('Log')->getCrashLogsByLimitAndKeyword($keyword, $paginate->offset(), $paginate->number());
		} else {
			$total = Business::factory('Log')->countCrashLogs();
			$paginate = Paginate::factory($total);
			$crashLogs = Business::factory('Log')->getCrashLogsByLimit($paginate->offset(), $paginate->number());
		}
		$this->_default->content = View::factory('log/crash')
			->set('crashLogs', $crashLogs)
			->set('pagination', $paginate);
	}
}