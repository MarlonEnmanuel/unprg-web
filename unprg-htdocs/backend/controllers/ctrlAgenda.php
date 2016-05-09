<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Agenda.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';


class ctrlAgenda extends abstractController{
	
	protected function init ($accion){
		$this->responder(false, "Acciones no implementadas");
	}


	public function create (){
		$Usuario=$this->checkAccess('agenda');

		$ipts = $this->getFilterInputs(array(
					'titulo'		=> array('type'=>'string', 'min'=>10, 'max'=>45),
					'fchInicio'		=> array('type'=>'datetime'),
					'texto'			=> array('type'=>'string'),
					'lugar'			=> array('type'=>'string', 'max'=>45),
					'mapa'			=> array('type'=>'url'),
					'organizador'	=> array('type'=>'string')
				));

		$mysqli = $this->getMysqli();
        
        $agenda =new Agenda($mysqli);
        $agenda->fchInicio			= $ipts['fchInicio'];
        $agenda->titulo				= $ipts['titulo'];
        $agenda->texto 				= $ipts['texto'];
        $agenda->lugar				= $ipts['lugar'];
        $agenda->mapa 				= $ipts['mapa'];
        $agenda->organizador 		= $ipts['organizador'];
        $agenda->idUsuario 			= $Usuario['id'];

        if(strpos($agenda->mapa, 'https://www.google.com/maps/embed?')===false){
        	$this->responder(false, "Mapa de google no válido");
        }
            
        if(!$agenda->set()){
        	$this->responder(false,"No se pudo guardar la agenda",$agenda->md_detalle,null);
        }
        

        $agenda->fchInicio = $agenda->fchInicio->format('U');

        $this->responder(true, "Agenda Creada!", '', $agenda->toArray());
        
	}


	public function update (){
		$Usuario=$this->checkAccess('agenda');

		$ipts = $this->getFilterInputs(array(
			'id'			=> array('type'=>'int', 'min'=>1),
			'titulo'		=> array('type'=>'string', 'min'=>10, 'max'=>45),
			'fchInicio'		=> array('type'=>'datetime'),
			'texto'			=> array('type'=>'string'),
			'lugar'			=> array('type'=>'string', 'max'=>45),
			'mapa'			=> array('type'=>'url'),
			'organizador'	=> array('type'=>'string'),
			'estado'		=> array('type'=>'boolean')
		));

		$mysqli=$this->getMysqli();

		$agenda = new Agenda($mysqli, $ipts['id']);
		$aux    = new Agenda($mysqli);

		if($agenda->get() == false){
			$this->responder(false, 'El agenda no existe');
		}

		if($agenda->idUsuario!=$Usuario['id'] && !$this->isAdmin()){
			$this->responder(false, 'Este agenda fue creado por otro usuario, no tiene permisos para modificarlo');
		}

		if($aux->getbyNombre($ipts['titulo'])){
			if($aux->id !== $agenda->id){
				$this->responder(false, "Ya existe un agenda con el nombre: ".$agenda->nombre);
			}
		}
        
		$agenda->fchInicio 		= $ipts['fchInicio'];
		$agenda->titulo			= $ipts['titulo'];
		$agenda->texto 			= $ipts['texto'];
		$agenda->lugar 			= $ipts['lugar'];
		$agenda->mapa 			= $ipts['mapa'];
		$agenda->organizador 	= $ipts['organizador'];
		$agenda->estado			= $ipts['estado'];

		if(strpos($agenda->mapa, 'https://www.google.com/maps/embed?')===false){
        	$this->responder(false, "Mapa de google no válido");
        }

		if($agenda->edit() == false) {
            $this->responder(false, "No se pudo actualizar el agenda", $agenda->md_detalle);
        }

        $agenda->fchInicio = $agenda->fchInicio->format('U');

        $this->responder(true, "agenda actualizado!", '', $agenda->toArray());
	}


	public function delete (){
		$Usuario=$this->checkAccess('agenda');

		$ipts = $this->getFilterInputs(array(
					'_id' => array('type'=>'int', 'min'=>1)
				));

		$mysqli=$this->getMysqli();

		$agenda = new Agenda($mysqli, $ipts['_id']);

		if($agenda->get() == false){
			$this->responder(false, 'El agenda no existe');
		}

		if($agenda->id != $Usuario['id'] && !$this->isAdmin()){
			$this->responder(false, 'Este agenda fue creado por otro usuario, no tiene permisos para modificarlo');
		}

		if($agenda->delete() == false) {
            $this->responder(false, "No se pudo eliminar el agenda", $agenda->md_detalle);
        }

        $this->responder(true, "Agenda eliminada!", '', array('status'=>'ok'));
	}




	public function read (){

	}


	public function readList (){
		$_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
		$_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

		$mysqli=$this->getMysqli();
		$aux=new Agenda($mysqli);

		$lista=$aux->searchNow($_limit, $_offset);

		if(empty($lista)) $this->responder(false, 'No hay eventos para mostrar');
		$agendas=array();

		foreach ($lista as $key => $agenda) {
			$agendas[$key]=$agenda->toArray();
			$agendas[$key]['fchInicio'] = $agendas[$key]['fchInicio']->format('U');
			$agendas[$key]['fchInicio_dia'] = $agenda->fchInicio->format('d');
			$agendas[$key]['fchInicio_mes'] = $this->mothName($agenda->fchInicio->format('m'));
			$agendas[$key]['fchInicio_hora'] = $agenda->fchInicio->format('H:i');
		}

        $this->responder(true, 'Agendas Obtenidas', '', $agendas);
	}


	public function readAll(){
		$Usuario=$this->checkAccess('agenda');

		$_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
		$_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

		$mysqli = $this->getMysqli();

		$aux = new Agenda($mysqli);

		$lista= $aux->search(false, $_limit, $_offset);

		$agendas=array();

		foreach ($lista as $key => $agenda) {
			$user= new Usuario($mysqli, $agenda->idUsuario);
			$user->get();
			$agendas[$key]=$agenda->toArray();
			$agendas[$key]['usuario'] = $user->email;
			$agendas[$key]['fchInicio']=$agendas[$key]['fchInicio']->format('U');
		}

		$this->responder(true, 'agendas obtenidas','',$agendas);
	}


	public function mothName($numberMonth){
		$num = intval($numberMonth);
		switch ($num) {
			case 1: return 'Ene';
			case 2: return 'Feb';
			case 3: return 'Mar';
			case 4: return 'Abr';
			case 5: return 'May';
			case 6: return 'Jun';
			case 7: return 'Jul';
			case 8: return 'Ago';
			case 9: return 'Sep';
			case 10: return 'Oct';
			case 11: return 'Nov';
			case 12: return 'Dic';
			default: return '---';
		}
	}

}

$ctrl=new ctrlAgenda(true);
?>