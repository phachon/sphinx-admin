<?php defined('SYSPATH') or die('No direct script access.');
/**
 * wiki管理
 * @author phachon@163.com
 */
class Controller_Wiki extends Controller_Render {

	protected $_default = 'layouts/wiki';

	/**
	 * index
	 */
	public function action_index() {
		$this->_default->content = View::factory('wiki/index');
	}
}