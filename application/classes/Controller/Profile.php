<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 个人中心管理
 * @author panchao
 */
class Controller_Profile extends Controller_Render {

	protected $_default = 'layouts/profile';

	public function action_index() {

		$account = Session::instance()->get('author');
		if(!$account) {
			Prompt::errorView('账号未登录', URL::site('author/index'));
		}
		$accounts = Business::factory('Account')->getAccountByAccountId($account['account_id']);
		$account = $accounts->current();
		if(!$account) {
			Prompt::errorView('账号不存在', URL::site('author/index'));
		}
		$this->_default->content = View::factory('profile/form')
			->set('account', $account);
	}

	/**
	 * 修改保存
	 */
	public function action_modify() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$accountId = Arr::get($_POST, 'account_id', 0);
		$name = Arr::get($_POST, 'name', '');
		$email = Arr::get($_POST, 'email', '');
		$mobile = Arr::get($_POST, 'mobile', '');
		$roleId = Arr::get($_POST, 'role_id', '');

		$errors = array ();
		if(!$accountId) {
			$errors[] = 'account_id 错误';
		}
		if(!$name) {
			$errors[] = '用户名错误';
		}
		if(!$mobile) {
			$errors[] = '手机号不能为空';
		}
		if($errors) {
			return $this->failed($errors[0]);
		}

		$values = array (
			'name' => $name,
			'email' => $email,
			'mobile' => $mobile,
			'role_id' => $roleId,
		);

		try {
			$result = Business::factory('Account')->updateByAccountId($values, $accountId);
			if(!$result) {
				Logs::instance()->write('修改个人资料失败');
				return $this->failed('修改个人资料失败');
			}
		} catch (Exception $e) {
			Logs::instance()->write('修改个人资料失败');
			return $this->failed('修改个人资料失败: '.$e->getMessage());
		}

		Logs::instance()->write('修改个人资料成功');

		return $this->success('修改个人资料成功', URL::site('profile/index'));
	}

	/**
	 * 修改密码
	 */
	public function action_editpass() {

		$account = Session::instance()->get('author');
		if(!$account) {
			Prompt::errorView('账号未登录', URL::site('author'));
		}
		$accounts = Business::factory('Account')->getAccountByAccountId($account['account_id']);
		if(!$accounts->count()) {
			Prompt::errorView('账号不存在', URL::site('author/index'));
		}

		$this->_default->content = View::factory('profile/password')
			->set('accountId', $account['account_id']);
	}

	/**
	 * 修改密码保存
	 */
	public function action_modifypass() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$accountId = Arr::get($_POST, 'account_id', '');
		$oldPassword = Arr::get($_POST, 'old_password', '');
		$newPassword = Arr::get($_POST, 'new_password', '');
		$renewPassword = Arr::get($_POST, 'renew_password', '');

		if(!$accountId) {
			Prompt::errorView('account_id 出错', URL::site('profile/info'));
		}

		$errors = array ();
		if(!$oldPassword) {
			$errors[] = '密码不能为空';
		}
		$account = Business::factory('Account')->getAccountByAccountId($accountId)->current();
		if($account->getPassword() != md5($oldPassword)) {
			$errors[] = '当前密码错误';
		}
		if(!$newPassword) {
			$errors[] = '新密码不能为空';
		}
		if($newPassword != $renewPassword) {
			$errors[] = '两次输入的密码不一致';
		}
		if($errors) {
			return $this->failed($errors[0]);
		}

		try {
			$result = Business::factory('Account')->updatePasswordByAccountId($newPassword, $accountId);
			if(!$result) {
				Logs::instance()->write('修改密码' .$accountId. '失败');
				return $this->error('修改密码' .$accountId. '失败');
			}
		} catch (Exception $e) {
			Logs::instance()->write('修改密码' .$accountId. '失败');
			return $this->error('修改密码' .$accountId. '失败: '.$e->getMessage());
		}

		Logs::instance()->write('修改密码' .$accountId. '成功');

		return $this->success('修改密码成功', URL::site('/'));
	}
}