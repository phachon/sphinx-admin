<?php
/**
 * Index Controller
 * @author: phachon@163.com
 */
class Controller_Main extends Controller_Render {

	protected $_default = 'layouts/index';

	/**
	 * index test
	 */
	public function action_index() {

		Controller::redirect('index/index');
	}
}