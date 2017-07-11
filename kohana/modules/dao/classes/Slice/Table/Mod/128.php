<?php
/**
 * Class Slice_Table_Mod_128
 */
class Slice_Table_Mod_128 extends Slice_Table {
	
	public function route() {
		return $this->_name.'_'.($this->_key % 128); 
	}
}