<?php
/*
 * Huy write
 */
	// controller
	class HomeControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			// call views
			if(empty($_COOKIE['user_id'])) {
				return;
			}else{
				include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
			}

		}

		function display404(){

		}
}
?>
