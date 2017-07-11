<?php
/**
 * 启动器
 * @author: panchao
 */
class Bootstrap {

	CONST EXT = '.php';

	public static $env = 'development';

	private static $_serviceId = 0;

	private static $_action = '';

	protected static $_modules = [];

	private $_typeMapping = [
		'1' => 'start',
		'2' => 'stop',
		'3' => 'rebuild',
	];

	/**
	 * @return Bootstrap
	 */
	public static function init() {
		return new self();
	}

	/**
	 * Bootstrap constructor.
	 */
	public function __construct() {}

	/**
	 * 检查 options 变量
	 */
	private function _checkOptions() {
		$env = CLI::options('env');
		$serviceId = CLI::options('serviceId');
		$action = CLI::options('action');

		if(!$env) {
			$this->_help('env options is must');
		}
		if(!in_array($env, ['development', 'production', 'staging'])) {
			$this->_help('env option error');
		}
		if($serviceId) {
			if(!is_numeric($serviceId)) {
				$this->_help('serviceId option error');
			}
			if(!$action) {
				$this->_help('single instance execute must have serviceId and action parameters');
			}
		}
		if($action) {
			if(!in_array($action, ['start', 'stop', 'rebuild'])) {
				$this->_help('action option error');
			}
		}

		self::$env = $env;
		self::$_serviceId = $serviceId;
		self::$_action = $action;
	}

	/**
	 * autoload
	 */
	private function _autoload() {
		spl_autoload_register(array('Bootstrap', 'loadClass'));
	}

	/**
	 * 加载的模块
	 * @param $modules
	 * @return $this
	 */
	public function modules($modules) {
		self::$_modules = $modules;
		return $this;
	}

	/**
	 * 自动加载 modules 文件夹下的类
	 * @param $className
	 */
	public static function loadClass($className) {

		$data = explode('_', $className);
		array_walk($data, function (&$value) {
			$value = ucfirst($value);
		});
		$classPath = implode($data, '/');

		foreach (self::$_modules as $module => $path) {
			if(!is_dir($path)) {
				exit('modules '.$module .' is not found');
			}
			if(file_exists($path . $classPath . self::EXT)) {
				include_once $path . $classPath . self::EXT;
				break;
			}
		}
	}

	/**
	 * 加载配置文件
	 */
	public function _configLoad() {

	}

	/**
	 * 执行
	 */
	public function _execute() {

		// 执行单个的实例
		if(self::$_serviceId) {
			try {
				Sphinx::factory(self::$_action)->serviceId(self::$_serviceId)->execute();
			} catch (Exception $e) {
				exit($e->getMessage());
			}
		}else {
			//该机器下的全部实例
			$tasks = Task::instance()->getTasksByIp();
			if(count($tasks)) {
				foreach ($tasks as $task) {
					try {
						Sphinx::factory($this->_typeMapping[$task['type']])->serviceId($task['service_id'])->execute();
					} catch (Exception $e) {
						Task::instance()->failedTask($task['task_id'], $e->getMessage());
						Logger::error("execute task {$task['task_id']} service_id error: ".$e->getMessage());
						continue;
					}
					Logger::info("execute task {$task['task_id']} error: ".$e->getMessage());
					Task::instance()->successTask($task['task_id'], '执行成功');
				}
			}
		}

	}

	/**
	 * help option
	 * @param string $message
	 */
	private function _help($message = '') {

		if($message) {
			echo 'Error: '. $message . "\r\n";
		}
		exit(
		"Usage: php client.php --env=[ENV] --serviceId=[serviceId] --action=[ACTION]
Env:
    development development environment
    production  production environment
    staging     staging environment
ServiceId:
    sphinx-admin service list id
Action:
    start start sphinx process
    stop stop sphinx process
    rebuild rebuild sphinx indexer
Example: 
    single instance: php client.php --env=production --serviceId=2 --action=start
    all instances: php client.php --env=development\r\n"
		);
	}

	/**
	 * run
	 */
	public function run() {
		$this->_autoload();
		$this->_checkOptions();
		$this->_configLoad();
		$this->_execute();
	}
}