<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';

class Controller extends abstractController {

    protected function init($accion){
        return false;
    }

    public function create (){
    	return false;
    }

	public function update (){
		return false;
	}

	public function delete (){
		return false;
	}

	public function read (){
		return false;
	}

	public function readList (){
		return false;
	}


}

?>