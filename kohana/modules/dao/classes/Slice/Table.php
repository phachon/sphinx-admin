<?php
/**
 * 表切分
 * Class Slice_Table
 */
abstract class Slice_Table {
	
	const MODE_NONE = 0;
	const MODE_TIME_MONTH = 1;
	const MODE_TIME_YEAR = 2;
	const MODE_MOD_16 = 3;
	const MODE_MOD_32 = 4;
	const MODE_MOD_64 = 5;
	const MODE_MOD_128 = 6;
	const MODE_MOD_256 = 7;
	const MODE_MOD_512 = 8;
	const MODE_HASH_MD5 = 9;
	
	protected $_name = '';
	
	protected $_key = NULL;

	/**
	 * @param $mode
	 * @return mixed
	 */
	static public function factory($mode) {

		switch ($mode) {
			case self::MODE_NONE:
				$className = "Slice_Table_None";
				break;
			case self::MODE_TIME_MONTH:
				$className = "Slice_Table_Time_Month";
				break;
			case self::MODE_TIME_YEAR:
				$className = "Slice_Table_Time_Year";
				break;
			case self::MODE_MOD_16:
				$className = "Slice_Table_Mod_16";
				break;
			case self::MODE_MOD_32:
				$className = "Slice_Table_Mod_32";
				break;
			case self::MODE_MOD_64:
				$className = "Slice_Table_Mod_64";
				break;
			case self::MODE_MOD_128:
				$className = "Slice_Table_Mod_128";
				break;
			case self::MODE_MOD_256:
				$className = "Slice_Table_Mod_256";
				break;
			case self::MODE_MOD_512:
				$className = "Slice_Table_Mod_512";
				break;
			case self::MODE_HASH_MD5:
				$className = "Slice_Table_Hash_Md5";
				break;
			default:
				$className = "Slice_Table_None";
			}

		return new $className();
	}
	
	public function name($name) {
		$this->_name = $name;
		return $this;
	}
	
	public function key($key) {
		$this->_key = $key;
		return $this;
	}
	
	abstract public function route();
}