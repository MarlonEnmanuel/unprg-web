<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Agenda.php';


class ctrlAgenda extends abstractController{
	
	protected function init($accion){
		if($accion=='read'){
			$this->read();
		}elseif ($accion=='create') {
			$this->create();
		}elseif ($accion=='update') {
			# code...
		}elseif ($accion=='delete') {
			# code...
		}
	}

	protected function read(){
		$mysqli=$this->getMysqli();
		$aux=new Agenda($mysqli);

		$lista=$aux->searchVisble();
		$agenda=array();

		foreach ($lista as $key => $agenda) {
			$arrayAgenda=array(
				'id'			=> $agenda->id,
				'fecha'			=> $agenda->fchInicio,
				'titulo'		=> $agenda->titulo,
				'texto'			=> $agenda->texto,
				'lugar'			=> $agenda->lugar,
				'mapa'			=> $agenda->mapa,
				'organizador'	=> $agenda->organizador,
				'estado'		=> $agenda->estado,
				'idUsuario'		=> $agenda->idUsuario
				);
			$agenda[$key]=$arrayAgenda;
		}

		if(empty($avisos)) $this->responder(false, 'No hay eventos para mostrar');

        $this->responder(true, 'Evento visible', '', $avisos);
	}

	protected function create(){
		$Usuario=$this->checkAccess('evento');

		$ops=array(
				'titulo'		=> array('type'=>'string'),
				'fchInicio'		=> array('type'=>'string'),
				'timeEvento'	=> array('type'=>'string'),
				'text'			=> array('type'=>'string'),
				'lugar'			=> array('type'=>'string'),
				'mapa'			=> array('type'=>'string'),
				'organizador'	=> array('type'=>'string')
			);

		$ipts=$this->getFilterInputs('post',$ops);

		$mysqli = $this->getMysqli();
        
        $mysqli->autocommit(false);

        $agenda =new Agenda($mysqli);
        
	}
}
?>