<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Moticia.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Galeria.php';

class ctrlNoticia extends abstractController{
	
	protected function init($accion){
        $this->responder(false, "Acciones no implementadas");
    }

    public function create(){
    	$Usuario=$this->checkAccess('noticia');

    	$ipts=$this->getFilterInputs(array(
    		''
    		));
    }

    public function update(){

    } 	

	public function delete(){

	}

	public function read(){

	}

	public function readList(){

	}

	public function readAll(){

	}
}

?>