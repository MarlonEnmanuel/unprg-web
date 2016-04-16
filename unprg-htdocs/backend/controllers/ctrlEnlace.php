<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Enlace.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';

class ctrlEnlace extends abstractController{
	
	protected function init ($accion){
		$this->responder(false, "Acciones no implementadas");
	}

	public function create (){
		$Usuario=$this->checkAccess('enlace');

		$ipts=$this->getFilterInputs(array(
			'nombre'		=> array('type'=>'string', 'min'=>3, 'max'=>45),
			'descripcion' 	=> array('type'=>'string'),
			'link' 			=> array('type'=>'url'),
			'estado'		=> array('type'=>'boolean')
		));

		$mysqli=$this->getMysqli();

		$enlace = new Enlace($mysqli);
		$aux    = new Enlace($mysqli);

		$enlace->nombre			= $ipts['nombre'];
		$enlace->descripcion 	= $ipts['descripcion'];
		$enlace->link 			= $ipts['link'];
		$enlace->estado			= $ipts['estado'];
		$enlace->idUsuario 		= $Usuario['id'];

		if($aux->getbyNombre($enlace->nombre)){
			$this->responder(false, "Ya existe un enlace con el nombre: ".$enlace->nombre);
		}

		if(!$enlace->set()) { //Insertando el aviso
            $this->responder(false, "No se pudo guardar el enlace", $enlace->md_detalle);
        }

        $this->responder(true, "Enlace creado!", '', $enlace->toArray());
	}

	public function update (){
		$Usuario=$this->checkAccess('enlace');

		$ipts = $this->getFilterInputs( array(
			'id'			=> array('type'=>'int', 'min'=>1),
			'nombre'		=> array('type'=>'string', 'min'=>3, 'max'=>45),
			'descripcion' 	=> array('type'=>'string'),
			'link' 			=> array('type'=>'url'),
			'estado'		=> array('type'=>'boolean')
		));

		$mysqli=$this->getMysqli();

		$enlace = new Enlace($mysqli, $ipts['id']);
		$aux    = new Enlace($mysqli);

		if($enlace->get() == false){
			$this->responder(false, 'El enlace no existe');
		}

		if($aux->getbyNombre($ipts['nombre'])){
			if($aux->id !== $enlace->id){
				$this->responder(false, "Ya existe un enlace con el nombre: ".$enlace->nombre);
			}
		}

		$enlace->nombre			= $ipts['nombre'];
		$enlace->descripcion 	= $ipts['descripcion'];
		$enlace->link 			= $ipts['link'];
		$enlace->estado			= $ipts['estado'];

		if($enlace->edit() == false) {
            $this->responder(false, "No se pudo guardar el enlace", $enlace->md_detalle);
        }

        $this->responder(true, "Enlace actualizado!", '', $enlace->toArray());
	}

	public function delete (){
		
	}

	public function read (){
		$Usuario=$this->checkAccess('enlace');

		$mysqli = $this->getMysqli();
        $aux = new Enlace($mysqli);

        $idUser=$Usuario['id'];
        $lista = $aux->searchUser($idUser);

        if(empty($lista)) $this->responder(false, 'No hay enlaces para mostrar');
        $enlaces = array();

        foreach ($lista as $key => $enlace) {
            $enlaces[$key]=$enlace->toArray();
            
        }

        $this->responder(true, 'enlaces obtenidos', '', $enlaces);
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