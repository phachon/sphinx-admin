<?php
/**
 * CLI execute
 */
class CLI {

	/**
	 * 解析 cli 参数
	 * 标准示例：php index.php --env=development --name=test --pass=test
	 *   CLI::options()                 //['env' => 'development', 'name' => 'test']
	 *   CLI::options('env', 'pass')    //['env' => 'development', 'name' => 'test']
	 *   CLI::options('env')            //'development'
	 * @param null $options 参数的 key 值
	 * @return array|mixed 返回的解析数据
	 */
	public static function options($options = NULL) {

		//获取函数的调用参数
		$options = func_get_args();
		$values = array();

		//去除第一个参数文件名
		for($i = 1; $i < $_SERVER['argc']; $i++) {

			if(!isset($_SERVER['argv'][$i])) {
				break;
			}

			$cliOption = $_SERVER['argv'][$i];

			if(substr($cliOption, 0, 2) !== '--') {
				$values[] = $cliOption;
				continue;
			}

			$cliOption = substr($cliOption, 2);

			if(strpos($cliOption, '=')) {
				list ($cliOption, $value) = explode('=', $cliOption, 2);
			}else {
				$value = NULL;
			}

			$values[$cliOption] = $value;
		}

		if($options) {
			foreach($values as $option => $value) {
				if (! in_array($option, $options)) {
					unset($values[$option]);
				}
			}
		}

		//options 只有一个参数，直接返回对应的值
		return count($options) == 1 ? array_pop($values) : $values;
	}
}