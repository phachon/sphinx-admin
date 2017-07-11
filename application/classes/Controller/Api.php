<?php
/**
 * 接口控制器基类
 * @author phachon@163.com
 */
class Controller_Api extends Controller {

	/**
	 * validate action
	 * @var array
	 */
	protected $_validateActions = [];

	/**
	 * return data type
	 * @var array
	 */
	protected $_dataTypes = ['json', 'xml', 'jsonp'];

	/**
	 * default header contentType
	 * @var string
	 */
	protected $_contentType = self::CONTENT_TYPE_JSON;

	/**
	 * auto response
	 * @var bool
	 */
	protected $_autoResponse = TRUE;

	/**
	 * data type
	 * @var null
	 */
	protected $_dataType = NULL;

	/**
	 * code
	 * @var int
	 */
	protected $_code = 1;

	/**
	 * data
	 * @var null
	 */
	protected $_data = [];

	/**
	 * message
	 * @var string
	 */
	protected $_message = 'ok';

	/**
	 * response body
	 * @var null
	 */
	protected $_body = NULL;

	/**
	 * validate appname
	 * @var string
	 */
	protected $_appname = '';

	/**
	 * validate token
	 * @var string
	 */
	protected $_token = '';

	/**
	 * jsonp callback
	 * @var null
	 */
	protected $_jsonpCallback = NULL;

	/**
	 * validate success
	 * @var bool
	 */
	private $_validateSuccess = TRUE;

	const CONTENT_TYPE_HTML = 'text/html';

	const CONTENT_TYPE_JSON = 'application/json';

	const CONTENT_TYPE_XML = 'text/xml';

	public function before() {

		$arguments = array_merge($_GET, $_POST);
		$this->_dataType = Arr::get($arguments, 'data_type', 'json');
		$this->_appname = Arr::get($arguments, 'appname', NULL);
		$this->_token = Arr::get($arguments, 'token', NULL);
		$this->_jsonpCallback = Arr::get($arguments, 'callback', NULL);

		parent::before();
	}

	public function execute() {
		$this->before();

		$action = $this->request->action();

		$actionFull = 'action_'.$action;

		if(!method_exists($this, $actionFull)) {
			exit('The requested URL :'. $this->request->uri() .' was not found on this server.');
		}

		//TODO 验证接口权限
		if(in_array($action, $this->_validateActions)) {
			$this->_validateSuccess = FALSE;
			$this->failed('接口验证失败');
		}

		if($this->_validateSuccess) {
			$this->{$actionFull}();
		}

		$this->after();

		return $this->response;
	}

	public function after() {
		$dataType = in_array($this->_dataType, $this->_dataTypes) ? $this->_dataType : 'json';

		if($dataType == 'json') {
			$this->response->headers('Content-type', self::CONTENT_TYPE_JSON);
		}

		if($dataType == 'xml') {
			$this->response->headers('Content-type', self::CONTENT_TYPE_XML);
		}

		if($dataType == 'jsonp') {
			$this->response->headers('Content-type', self::CONTENT_TYPE_JSON);
		}

		if($this->_autoResponse === TRUE) {
			$data = array(
				'code' => $this->_code,
				'message' => $this->_message,
				'data' => $this->_data
			);

			if($dataType == 'json') {
				$this->_body = json_encode($data);
			}

			if($dataType == 'xml') {
				$this->_body = Xmld::arrayToXml($data);
			}

			if($dataType == 'jsonp') {
				$this->_body = htmlspecialchars($this->_jsonpCallback) . '(' . json_encode($data) . ')';
			}
		}
		$this->response->body($this->_body);

		parent::after();
	}

	public function success($message = '', $data = []) {
		$this->_code = 1;
		$this->_data = $data;
		$this->_message = $message;
	}

	public function failed($message = '') {
		$this->_code = 0;
		$this->_data = [];
		$this->_message = $message;
	}
}