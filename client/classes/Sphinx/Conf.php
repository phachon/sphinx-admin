<?php
/**
 * Sphinx Conf 生成类
 * @author: phachon@163.com
 */
class Sphinx_Conf {

	protected $_template = ETC_PATH.'sphinx_template.php';

	protected $_service = [];
	protected $_machine = [];
	protected $_columns = [];
	protected $_indexer = [];
	protected $_searchd = [];

	public function __construct($service, $machine, $columns, $indexer, $searchd) {
		$this->_service = $service;
		$this->_machine = $machine;
		$this->_columns = $columns;
		$this->_indexer = $indexer;
		$this->_searchd = $searchd;
	}

	public function make() {

		$searchd = $this->_searchd;
		$service = $this->_service;
		$sphinxPath = $this->_machine['sphinx_path'];
		$config = Config::load('sphinx');
		$rtAttrMap = $config['rt_attr_map'];
		$ngramChars = $config['ngram_chars'];
		$charsetTable = $config['charset_table'];

		$plainIndex = [];
		$rtIndex = [];
		foreach ($this->_indexer as $index) {
			if($index['type'] == 'plain') {
				$plainIndex = [
					'name' => $index['name'],
				];
			}
			if($index['type'] == 'rt') {
				$rtIndex = [
					'name' => $index['name'],
				];
			}
			if($index['type'] == 'dis') {
				//TODO 分布式索引
				return;
			}
		}

		$sqlQuery = 'SELECT ';
		$sqlJoinedField = '';
		$sqlCondition = '';
		$columns = '';
		$rtColumns = '';
		foreach ($this->_columns as $column) {
			$columns .= "    {$column['column_attr']}  = {$column['column']}\n";
			$rtColumns .= "    {$rtAttrMap[$column['column_attr']]}  = {$column['column']}\n";
			$sqlJoinedField = $column['sql_joined_field'];
			$sqlCondition = $column['sql_condition'];
			if($column['is_id_column']) {
				$sqlQuery .= $column['column'] . " as id,";
			}
			$sqlQuery .= $column['column'] .",";
		}
		$sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 1);

		ob_start();
		include $this->_template;
		$conf = ob_get_contents();
		ob_end_clean();

		file_put_contents(ETC_PATH.$service['name'].'.conf', $conf);
	}
}