<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 渲染模板控制器基类
 * @author phachon@163.com
 */
class Controller_Render extends Controller {

	/**
	 * 默认的view
	 */
	protected $_default = 'layouts/default';

	/**
	 * 是否验证登录
	 * @var bool
	 */
	protected $_checkLogin = TRUE;

	/**
	 * 是否自动渲染模板
	 **/
	protected $_autoRender = TRUE;

	/**
	 * 是否加载 header footer 部分
	 * @var bool
	 */
	protected $_headerRender = TRUE;

	/**
	 * code
	 * @var int
	 */
	protected $_code = 1;

	/**
	 * auto return json message
	 * @var string
	 */
	protected $_message = '';

	/**
	 * auto return json redirect
	 * @var null
	 */
	protected $_redirect = null;

	/**
	 * auto return json data
	 * @var array
	 */
	protected $_data = [];

	/**
	 * return body
	 * @var string
	 */
	protected $_body = '';

	/**
	 * login url
	 * @var string
	 */
	protected $_loginURL = '';

	/**
	 * validate success
	 * @var bool
	 */
	private $_validateSuccess = TRUE;

	/**
	 * default header contentType
	 * @var string
	 */
	protected $_contentType = self::CONTENT_TYPE_HTML;

	const CONTENT_TYPE_HTML = 'text/html';

	const CONTENT_TYPE_JSON = 'application/json';

	const CONTENT_TYPE_XML = 'text/xml';

	/**
	 * Loads the template [View] object.
	 */
	public function before() {

		parent::before();

		if($this->_autoRender === TRUE) {
			if($this->_contentType == self::CONTENT_TYPE_HTML) {
				$this->_default = View::factory($this->_default);
			}
		}
	}

	public function execute() {
		$this->before();

		$action = $this->request->action();

		$actionFull = 'action_'.$action;

		if(!method_exists($this, $actionFull)) {
			exit('The requested URL :'. $this->request->uri() .' was not found on this server.');
		}

		//TODO 验证登录
		if($this->_checkLogin) {
			$login = Author::instance()->isLogin();
			if(!$login) {
				Controller::redirect('author');
			}
		}
		$this->{$actionFull}();

		$this->after();

		return $this->response;
	}

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after() {
		$this->response->headers('Content-type', $this->_contentType);

		if($this->_autoRender === TRUE) {
			$body = array(
				'code' => $this->_code,
				'message' => $this->_message,
				'redirect' => $this->_redirect,
				'data' => $this->_data
			);

			if($this->_contentType == self::CONTENT_TYPE_HTML) {
				if($this->_headerRender) {
					$this->loadHeader();
				}
				$this->_body = $this->_default->render();
			}
			if($this->_contentType == self::CONTENT_TYPE_JSON) {
				$this->_body = json_encode($body, true);
			}
			if($this->_contentType == self::CONTENT_TYPE_XML) {
				$this->_body = Xmld::arrayToXml($body);
			}

		}

		$this->response->body($this->_body);

		parent::after();
	}

	public function loadHeader() {
		//TODO 导航权限控制

		$menus = Kohana::$config->load('menus')->as_array();
		$this->_default->header = View::factory('index/header')
			->set('menus', $menus);
		$this->_default->footer = View::factory('index/footer');
	}

	/**
	 * return json when failed
	 * @param string $messages
	 * @param string $redirect
	 * @param array $data
	 */
	public function failed($messages, $redirect = '', $data = []) {
		$this->_code = 0;
		$this->_message = $messages;
		$this->_redirect = $redirect;
		$this->_data = $data;
	}

	/**
	 * return json when success
	 * @param string $messages
	 * @param string $redirect
	 * @param array $data
	 */
	public function success($messages, $redirect = '', $data = []) {
		$this->_code = 1;
		$this->_message = $messages;
		$this->_redirect = $redirect;
		$this->_data = $data;
	}
}