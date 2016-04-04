<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';

class Controller extends abstractController {

    protected function init($accion){
        return false;
    }

    public function create ($model){
    	return false;
    }

	public function update ($model){
		return false;
	}

	public function delete ($_id){
		return false;
	}

	public function read ($_id){
		return false;
	}

	public function readList ($limit, $offset){
		return false;
	}


}

?>