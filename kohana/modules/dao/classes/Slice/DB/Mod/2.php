<?php
/**
 * Class Slice_DB_Mod_2
 */
class Slice_DB_Mod_2 extends Slice_DB {
	
	public function route() {
		return $this->_name.'_'.($this->_key % 2); 
	}
}