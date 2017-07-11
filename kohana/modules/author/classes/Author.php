<?php
/**
 * 登录控制
 * @author: phachon@163.com
 */
class Author {

	protected static $_instance = NULL;

	protected $_config = [];

	protected $_accountId = 0;

	protected $_name = '';

	/**
	 * instance
	 * @return Author|null
	 * @throws Kohana_Exception
	 */
	public static function instance() {
		if(self::$_instance === NULL) {
			$config = Kohana::$config->load('author')->as_array();
			self::$_instance = new self($config);
		}

		return self::$_instance;
	}

	/**
	 * Author constructor.
	 * @param $config
	 */
	public function __construct($config) {
		$this->_config = $config;

		$author = Session::instance()->get('author', []);
		if(isset($author['account_id'])) {
			$this->_accountId = $author['account_id'];
		}
		if(isset($author['name'])) {
			$this->_name = $author['name'];
		}
	}

	/**
	 * 登录
	 * @param $name
	 * @param $password
	 * @throws Author_Exception
	 */
	public function login($name, $password) {
		if(!$name) {
			throw new Author_Exception('用户名不能为空');
		}
		if(!$password) {
			throw new Author_Exception('密码不能为空');
		}

		$accounts = Business::factory('Account')->getAccountByName($name);
		if(!$accounts || !$accounts->count()) {
			throw new Author_Exception('账号不存在');
		}
		$account = $accounts->current();
		if($account->getStatus() == Model_Account::STATUS_DISABLE) {
			throw new Author_Exception('账号已被屏蔽');
		}
		if($account->getPassword() !== md5($password)) {
			throw new Author_Exception('密码错误');
		}

		$accountInfo = get_object_vars($account);

		Session::instance()->set('author', $accountInfo);

		$identifier = md5(Request::$user_agent . Request::$client_ip . $accountInfo['password']);
		$data = $accountInfo['name'] . "@" . $identifier;
		$cookie = Encrypt::instance('author')->encode($data);

		Cookie::set($this->_config['passport'], $cookie);
	}

	/**
	 * 是否登录
	 * @return bool
	 * @throws Author_Exception
	 */
	public function isLogin() {

		$cookie = Cookie::get($this->_config['passport']);
		if(!$cookie) {
			return FALSE;
		}

		$encrypt = Encrypt::instance('author')->decode($cookie);
		$info = explode('@', $encrypt);
		$name = $info[0];
		$identifier = $info[1];

		$author = Session::instance()->get('author');

		// session 失效,验证cookie
		if(!$author || isset($author['name']) || ($name != $author['name'])) {
			$accounts = Business::factory('Account')->getAccountByName($name);
			if(!$accounts || !$accounts->count()) {
				return FALSE;
			}
			$account = get_object_vars($accounts->current());

			$data = md5(Request::$user_agent . Request::$client_ip . $account['password']);
			if($data !== $identifier) {
				return FALSE;
//				throw new Author_Exception('登录已失效');
			}

			Session::instance()->set('author', $account);
		}

		return TRUE;
	}

	public function getAccountId() {
		return $this->_accountId;
	}

	public function getName() {
		return $this->_name;
	}

	public static function accountId() {
		return Author::instance()->getAccountId();
	}

	public static function accountName() {
		return Author::instance()->getName();
	}
}