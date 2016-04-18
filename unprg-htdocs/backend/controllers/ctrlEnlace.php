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

		$ipts = $this->getFilterInputs(array(
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
            $this->responder(false, "No se pudo actualizar el enlace", $enlace->md_detalle);
        }

        $this->responder(true, "Enlace actualizado!", '', $enlace->toArray());
	}


	public function delete (){
		$Usuario=$this->checkAccess('enlace');

		$ipts = $this->getFilterInputs(array(
					'_id' => array('type'=>'int', 'min'=>1)
				));

		$mysqli=$this->getMysqli();

		$enlace = new Enlace($mysqli, $ipts['_id']);

		if($enlace->get() == false){
			$this->responder(false, 'El enlace no existe');
		}

		if($enlace->delete() == false) {
            $this->responder(false, "No se pudo eliminar el enlace", $enlace->md_detalle);
        }

        $this->responder(true, "Enlace eliminado!", '', array('status'=>'ok'));
	}


	public function read (){
	}


	public function readList (){
		$mysqli = $this->getMysqli();

		$_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
		$_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

        $aux = new Enlace($mysqli);

        $lista = $aux->search(true, $_limit, $_offset);

        if(empty($lista)){
        	$this->responder(false, 'No hay enlaces para mostrar');
        }

        $enlaces = array();
        foreach ($lista as $key => $enlace) {
            $enlaces[$key] = $enlace->toArray();
        }

        $this->responder(true, 'enlaces obtenidos', '', $enlaces);
	}


	public function readAll(){
		$Usuario=$this->checkAccess('enlace');

		$_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
		$_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

		$mysqli = $this->getMysqli();

        $aux = new Enlace($mysqli);

        $lista = $aux->search(false, $_limit, $_offset);

        $enlaces = array();
        foreach ($lista as $key => $enlace) {
        	$user = new Usuario($mysqli, $enlace->idUsuario);
        	$user->get();
            $enlaces[$key] = $enlace->toArray();
            $enlaces[$key]['usuario'] = $user->email;
        }

        $this->responder(true, 'enlaces obtenidos', '', $enlaces);
	}


}

$ctrl=new ctrlEnlace(true);
?>