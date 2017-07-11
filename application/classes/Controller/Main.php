<?php
/**
 * Index Controller
 * @author: panchao
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