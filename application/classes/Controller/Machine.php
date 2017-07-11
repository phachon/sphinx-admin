<?php
/**
 * 机器管理
 * @author: phachon@163.com
 */
class Controller_Machine extends Controller_Render {

	protected $_default = 'layouts/machine';

	/**
	 * index
	 */
	public function action_index() {
		Controller::redirect('machine/list');
	}

	/**
	 * 机器列表
	 */
	public function action_list() {

		$keyword = trim(Arr::get($_GET, 'keyword', ''));
		if($keyword) {
			$total = Business::factory('Machine')->countMachinesBykeyword($keyword);
			$paginate = Paginate::factory($total);
			$machines = Business::factory('Machine')->getMachinesByKeywordAndLimit($keyword, $paginate->offset(), $paginate->number());
		} else {
			$total = Business::factory('Machine')->countMachines();
			$paginate = Paginate::factory($total);
			$machines = Business::factory('Machine')->getMachinesByLimit($paginate->offset(), $paginate->number());
		}

		$this->_default->content = View::factory('machine/list')
			->set('machines', $machines)
			->set('paginate', $paginate);
	}

	/**
	 * 添加机器
	 */
	public function action_add() {
		$this->_default->content = View::factory('machine/add');
	}

	/**
	 * 添加保存
	 */
	public function action_save() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$domain = Arr::get($_POST, 'domain', '');
		$ip = Arr::get($_POST, 'ip', '');
		$sphinxPath = Arr::get($_POST, 'sphinx_path', '');
		$comment = Arr::get($_POST, 'comment', '');

		$values = [
			'domain' => trim($domain),
			'ip' => trim($ip),
			'sphinx_path' => trim($sphinxPath),
			'comment' => trim($comment)
		];

		try {
			$machine = Business::factory('Machine')->create($values);
		} catch (Exception $e) {
			Logs::instance()->write('添加机器失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		Logs::instance()->write('添加机器' .$machine[0]. '成功');
		return $this->success('添加机器成功', URL::site('machine/list'));
	}

	/**
	 * 机器修改
	 */
	public function action_edit() {
		$this->_headerRender = FALSE;

		$machineId = Arr::get($_GET, 'machine_id', 0);
		if(!$machineId) {
			Prompt::warningView('machine_id 不合法', URL::site('machine/list'));
		}

		$machines = Business::factory('Machine')->getMachineByMachineId($machineId);
		$machine = $machines->current();
		if(!$machine) {
			Prompt::warningView('机器不存在', URL::site('machine/list'));
		}

		$this->_default->content = View::factory('machine/edit')
			->set('machine', $machine);
	}

	/**
	 * 修改保存
	 */
	public function action_modify() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$machineId = Arr::get($_POST, 'machine_id', '');
		$domain = Arr::get($_POST, 'domain', '');
		$ip = Arr::get($_POST, 'ip', '');
		$sphinxPath = Arr::get($_POST, 'sphinx_path', '');
		$comment = Arr::get($_POST, 'comment', '');

		$values = [
			'domain' => $domain,
			'ip' => $ip,
			'sphinx_path' => $sphinxPath,
			'comment' => $comment
		];

		try {
			Business::factory('Machine')->updateByMachineId($values, $machineId);
		} catch (Exception $e) {
			Logs::instance()->write('修改机器 '.$machineId.' 失败: '.$e->getMessage());
			return $this->failed('修改机器失败');
		}

		Logs::instance()->write('修改机器' .$machineId. '成功');
		return $this->success('修改机器成功', URL::site('machine/list'));
	}

	/**
	 * 删除
	 */
	public function action_delete() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$machineId = Arr::get($_GET, 'machine_id', 0);
		if(!$machineId) {
			Prompt::warningView('machine_id 不合法', URL::site('machine/list'));
		}
		$machine = Business::factory('Machine')->getMachineByMachineId($machineId);
		$machine = $machine->current();
		if(!$machine) {
			Prompt::warningView('机器不存在', URL::site('machine/list'));
		}

		$status = Model_Machine::STATUS_DELETE;

		try {
			Business::factory('machine')->updateStatusByMachineId($status, $machineId);
		} catch (Exception $e) {
			Logs::instance()->write('删除机器' .$machineId. '失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		Logs::instance()->write('删除机器' .$machineId. '成功');
		return $this->success('删除机器成功', URL::site('machine/list'));
	}
}