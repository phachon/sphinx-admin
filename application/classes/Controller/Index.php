<?php
/**
 * 首页管理
 * @author: panchao
 */
class Controller_Index extends Controller_Render {

	protected $_default = 'layouts/index';

	/**
	 * index test
	 */
	public function action_index() {

		$this->_default->content = View::factory('index/main');
	}
}