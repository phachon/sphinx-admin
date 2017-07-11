<?php
/**
 * 用户管理
 * @author: phachon@163.com
 */
class Controller_account extends Controller_Render {

	protected $_default = 'layouts/account';

	/**
	 * index
	 */
	public function action_index() {
		Controller::redirect('account/list');
	}

	/**
	 * 账号列表
	 */
	public function action_list() {

		$keyword = trim(Arr::get($_GET, 'keyword', ''));
		if($keyword) {
			$total = Business::factory('Account')->countAccountsBykeyword($keyword);
			$paginate = Paginate::factory($total);
			$accounts = Business::factory('Account')->getAccountsByKeywordAndLimit($keyword, $paginate->offset(), $paginate->number());
		} else {
			$total = Business::factory('Account')->countAccounts();
			$paginate = Paginate::factory($total);
			$accounts = Business::factory('Account')->getAccountsByLimit($paginate->offset(), $paginate->number());
		}
		$this->_default->content = View::factory('account/list')
			->set('accounts', $accounts)
			->set('paginate', $paginate);
	}

	/**
	 * 账号列表
	 */
	public function action_add() {

		$roles = Role::instance()->getRoles();

		$this->_default->content = View::factory('account/form')
			->set('roles', $roles);
	}

	/**
	 * 保存
	 */
	public function action_save() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$name = Arr::get($_POST, 'name', '');
		$email = Arr::get($_POST, 'email', '');
		$mobile = Arr::get($_POST, 'mobile', '');
		$roleId = Arr::get($_POST, 'role_id', '');
		$password = Arr::get($_POST, 'password', '');

		$values = [
			'name' => trim($name),
			'email' => trim($email),
			'mobile' => trim($mobile),
			'role_id' => intval($roleId),
			'password' => trim($password),
		];

		try {
			$accounts = Business::factory('Account')->create($values);
		}catch (Exception $e) {
			Logs::instance()->write('添加账号失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		Logs::instance()->write('添加账号 '.$accounts[0].' 成功');
		return $this->success('添加账号成功', URL::site('account/list'));
	}

	/**
	 * 修改
	 */
	public function action_edit() {
		$this->_headerRender = FALSE;

		$accountId = Arr::get($_GET, 'account_id', 0);
		if(!$accountId) {
			Prompt::warningView('account_id 不合法', URL::site('account/list'));
		}

		$account = Business::factory('Account')->getAccountByAccountId($accountId);
		$account = $account->current();
		if(!$account) {
			Prompt::warningView('账号不存在', URL::site('account/list'));
		}

		$roles = Role::instance()->getRoles();

		$this->_default->content = View::factory('account/edit')
			->set('account', $account)
			->set('roles', $roles);
	}

	/**
	 * 修改保存
	 */
	public function action_modify() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$accountId = Arr::get($_POST, 'account_id', '');
		$name = Arr::get($_POST, 'name', '');
		$email = Arr::get($_POST, 'email', '');
		$mobile = Arr::get($_POST, 'mobile', '');
		$roleId = Arr::get($_POST, 'role_id', '');

		$values = [
			'name' => trim($name),
			'email' => trim($email),
			'mobile' => trim($mobile),
			'role_id' => trim($roleId)
		];

		try {
			Business::factory('Account')->updateByAccountId($values, $accountId);
		}catch (Exception $e) {
			Logs::instance()->write('修改账号 '.$accountId.' 失败: '.$e->getMessage());
			return $this->failed($e->getMessage());
		}

		Logs::instance()->write('修改账号 '.$accountId.' 成功');
		return $this->success('修改账号成功', URL::site('account/list'));
	}

	/**
	 * 屏蔽
	 */
	public function action_disable() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$accountId = Arr::get($_GET, 'account_id', 0);
		if(!$accountId) {
			Prompt::warningView('account_id 不合法', URL::site('account/list'));
		}
		$account = Business::factory('Account')->getAccountByAccountId($accountId);
		$account = $account->current();
		if(!$account) {
			Prompt::warningView('账号不存在', URL::site('account/list'));
		}

		$status = Model_Account::STATUS_DISABLE;

		try {
			$result = Business::factory('Account')->updateStatusByAccountId($status, $accountId);
			if(!$result) {
				Logs::instance()->write('屏蔽账号' .$accountId. '失败');
				return $this->failed('屏蔽账号失败');
			}
		} catch (Exception $e) {
			Logs::instance()->write('屏蔽账号' .$accountId. '失败');
			return $this->failed('屏蔽账号失败: '.$e->getMessage());
		}

		Logs::instance()->write('屏蔽账号' .$accountId. '成功');
		return $this->success('屏蔽账号成功', URL::site('account/list'));
	}

	/**
	 * 恢复
	 */
	public function action_review() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$accountId = Arr::get($_GET, 'account_id', 0);
		if(!$accountId) {
			Prompt::warningView('account_id 不合法', URL::site('account/list'));
		}
		$account = Business::factory('Account')->getAccountByAccountId($accountId);
		$account = $account->current();
		if(!$account) {
			Prompt::warningView('账号不存在', URL::site('account/list'));
		}

		$status = Model_Account::STATUS_NORMAL;

		try {
			$result = Business::factory('Account')->updateStatusByAccountId($status, $accountId);
			if(!$result) {
				Logs::instance()->write('恢复账号' .$accountId. '失败');
				return $this->failed('恢复账号失败');
			}
		} catch (Exception $e) {
			Logs::instance()->write('恢复账号' .$accountId. '失败');
			return $this->failed('恢复账号失败: '.$e->getMessage());
		}

		Logs::instance()->write('恢复账号' .$accountId. '成功');
		return $this->success('恢复账号成功', URL::site('account/list'));
	}
}