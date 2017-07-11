<?php
/**
 * 登录管理
 * @author: panchao
 */
class Controller_Author extends Controller_Render {

	protected $_default = 'layouts/author';

	protected $_checkLogin = FALSE;

	/**
	 * index test
	 */
	public function action_index() {

		$this->_default->content = View::factory('author/login');
	}

	/**
	 * 登录
	 */
	public function action_login() {
		$this->_contentType = self::CONTENT_TYPE_JSON;

		$name = trim(Arr::get($_POST, 'name', ''));
		$password = trim(Arr::get($_POST, 'password', ''));

		try {
			Author::instance()->login($name, $password);
		}catch (Exception $e) {
			return $this->failed($e->getMessage());
		}

		return $this->success('恭喜登录成功', URL::site('main/index'));
	}

	/**
	 * 退出
	 */
	public function action_logout() {

		$account = Session::instance()->get('author');
		if($account) {
			Logs::instance()->write($account['name'].' 退出登录');
		}
		$config = Kohana::$config->load('author');
		Cookie::delete($config['passport']);
		Session::instance()->delete('author');

		Prompt::successView('退出成功', URL::site('author'));
	}

}