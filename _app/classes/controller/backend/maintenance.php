<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Backend_Maintenance extends Controller_Themes_DefaultMaintenance {

	public function before () {
		parent::before();
		
		//print_r($this);
		//exit;
	}
	
	public function action_index () { 		
		if (empty($this->is_maintenance))
			$this->request->redirect(URL::site());	
	}
			
}