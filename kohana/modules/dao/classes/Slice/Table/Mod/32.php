<?php
/**
 * Class Slice_Table_Mod_32
 */
class Slice_Table_Mod_32 extends Slice_Table {
	
	public function route() {
		return $this->_name.'_'.($this->_key % 32);
	}
}