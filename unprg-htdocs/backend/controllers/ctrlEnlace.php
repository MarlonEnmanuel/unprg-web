<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Enlace.php';

class ctrlEnlace extends abstractController{
	
	protected function init ($accion){
		$this->responder(false, "Acciones no implementadas");
	}

	public function create (){
		$Usuario=$this->checkAccess('enlace');
		$ops=array(
			'nombre'		=> array('type'=>'string'),
			'descripcion' 	=> array('type'=>'string'),
			'link' 			=> array('type'=>'string')
			);
		$ipts=$this->getFilterInputs('post',$ops);
		$mysqli=$this->getMysqli();

		$enlace=new Enlace($mysqli);

		$enlace->nombre			= $ipts['nombre'];
		$enlace->descripcion 	= $ipts['descripcion'];
		$enlace->link 			= $ipts['link'];
		$enlace->idUsuario 		= $Usuario['id'];

		if(!$enlace->set()) { //Insertando el aviso
            $this->responder(false, "No se pudo guardar el enlace", $enlace->md_detalle, null, $mysqli);
        }


        $this->responder(true, "Enlace creado!");
	}

	public function update (){

	}

	public function delete (){

	}

	public function read (){

	}

	public function readList (){
		$mysqli = $this->getMysqli();
        $aux = new Enlace($mysqli);

        $lista = $aux->search(true, 6);
        if(empty($lista)) $this->responder(false, 'No hay enlaces para mostrar');
        $enlaces = array();

        foreach ($lista as $key => $enlace) {
            $enlaces[$key]=$enlace->toArray();
            
        }

        $this->responder(true, 'enlaces obtenidos', '', $enlaces);
	}

}

$ctrl=new ctrlEnlace(true);
?>