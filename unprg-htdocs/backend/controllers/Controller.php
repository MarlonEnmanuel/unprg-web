<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';

class Controller extends abstractController {

    protected function init($accion){
        return false;
    }

}

?>