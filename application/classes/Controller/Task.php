<?php
/**
 * 任务管理
 * @author: phachon@163.com
 */
class Controller_Task extends Controller_Render {

	protected $_default = 'layouts/task';

	/**
	 * index
	 */
	public function action_index() {
		Controller::redirect('task/list');
	}

	/**
	 * 任务列表
	 */
	public function action_list() {

		$keyword = trim(Arr::get($_GET, 'keyword', ''));
		if($keyword) {
			$total = Business::factory('Task')->countTasksBykeyword($keyword);
			$paginate = Paginate::factory($total);
			$tasks = Business::factory('Task')->getTasksByKeywordAndLimit($keyword, $paginate->offset(), $paginate->number());
		} else {
			$total = Business::factory('Task')->countTasks();
			$paginate = Paginate::factory($total);
			$tasks = Business::factory('Task')->getTasksByLimit($paginate->offset(), $paginate->number());
		}

		$this->_default->content = View::factory('task/list')
			->set('tasks', $tasks)
			->set('paginate', $paginate);
	}
}