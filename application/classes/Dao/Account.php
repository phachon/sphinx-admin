<?php
/**
 * 数据访问 - 账号
 * @author: panchao
 */
class Dao_Account extends Dao {

	protected $_db = 'sphinx';

	protected $_tableName = 'account';

	protected $_primaryKey = 'account_id';

	protected $_modelName = 'Model_Account';

	const STATUS_NORMAL = 0;
	const STATUS_DISABLE = -1;

	/**
	 * 插入一条信息
	 * @param array $values
	 * @return array
	 */
	public function insert(array $values) {
		return DB::insert($this->_tableName)
			->columns(array_keys($values))
			->values(array_values($values))
			->execute($this->_db);
	}

	/**
	 * 根据用户名查找账号
	 * @param $name
	 * @return object
	 */
	public function getAccountByName($name) {
		return DB::select('*')
			->from($this->_tableName)
			->where('name', '=', $name)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据关键字获取账号数量
	 * @param string $keyword
	 * @return array
	 */
	public function countAccountsByKeyword($keyword) {
		$select = DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName);
		if($keyword) {
			$select->where('name', 'LIKE', '%'.$keyword.'%')
				->or_where($this->_primaryKey, '=', $keyword);
		}
		return $select->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 根据关键字分页获取账号
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getAccountsByKeywordAndLimit($keyword, $offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName);
		if($keyword) {
			$select->where('name', 'LIKE', '%'.$keyword.'%')
				->or_where($this->_primaryKey, '=', $keyword);
		}
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}

		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 获取账号总数
	 * @return array
	 */
	public function countAccounts() {
		return DB::select(DB::expr('count(*) AS recordCount'))
			->from($this->_tableName)
			->execute($this->_db)
			->get('recordCount');
	}

	/**
	 * 分页获取账号信息
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getAccountsByLimit($offset, $number) {

		$select = DB::select('*')
			->from($this->_tableName);
		if($offset) {
			$select->offset($offset);
		}
		if($number) {
			$select->limit($number);
		}

		return $select->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 account_id 来查找账号
	 * @param integer $accountId
	 * @return array
	 */
	public function getAccountByAccountId($accountId) {
		return DB::select('*')
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $accountId)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 account_id 来查找正常的账号
	 * @param integer $accountId
	 * @return array
	 */
	public function getNormalAccountByAccountId($accountId) {
		return DB::select('*')
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $accountId)
			->and_where('status', '=', self::STATUS_NORMAL)
			->as_object($this->_modelName)
			->execute($this->_db);
	}

	/**
	 * 根据 accountId 修改账号信息
	 * @param array $values
	 * @param integer $accountId
	 * @return integer
	 */
	public function updateByAccountId($values, $accountId) {
		return DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $accountId)
			->execute($this->_db);
	}

	/**
	 * 获取所有的账号
	 * @return array
	 */
	public function getAccounts() {
		return DB::select('*')
			->from($this->_tableName)
			->as_object($this->_modelName)
			->execute();
	}
}