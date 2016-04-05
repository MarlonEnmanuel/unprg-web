<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Agenda.php';


class ctrlAgenda extends abstractController{
	
	protected function init ($accion){
		
	}

	public function create ($model){

		$Usuario=$this->checkAccess('evento');

		$ops=array(
				'titulo'		=> array('type'=>'string'),
				'fchInicio'		=> array('type'=>'string'),
				'timeEvento'	=> array('type'=>'string'),
				'texto'			=> array('type'=>'string'),
				'lugar'			=> array('type'=>'string'),
				'mapa'			=> array('type'=>'url'),
				'organizador'	=> array('type'=>'string')
			);

		$ipts=$this->getFilterInputs('post',$ops);

		$mysqli = $this->getMysqli();
    	    
        
        $aux=$ipts['fchInicio'].' '.$ipts['timeEvento'];
        $fchInicio= DateTime::createFromFormat(config::$date_fechaHora,$aux);
        $agenda =new Agenda($mysqli);
        $agenda->fchInicio			= $fchInicio;
        $agenda->titulo				= $ipts['titulo'];
        $agenda->texto 				= $ipts['texto'];
        $agenda->lugar				= $ipts['lugar'];
        $agenda->mapa 				= $ipts['mapa'];
        $agenda->organizador 		= $ipts['organizador'];
        $agenda->idUsuario 			= $Usuario['id'];

        if(!$agenda->set()){
        	$this->responder(false,"No se pudo guardar la agenda",$agenda->md_detalle,null,$mysqli);
        }

        $this->responder(true,"Agenda Creada!");
	}
	public function update ($model){

	}
	public function delete ($_id){

	}
	public function read ($_id){

	}
	public function readList ($limit, $offset){
		$top=5;$offset=0;

		$mysqli=$this->getMysqli();
		$aux=new Agenda($mysqli);

		$lista=$aux->searchNow();
		$agendas=array();

		foreach ($lista as $key => $agenda) {
			$arrayAgenda=array(
				'id'			=> $agenda->id,
				'fecha'			=> $agenda->fchInicio->format(config::$date_fechaHora),
				'titulo'		=> $agenda->titulo,
				'texto'			=> $agenda->texto,
				'lugar'			=> $agenda->lugar,
				'mapa'			=> $agenda->mapa,
				'organizador'	=> $agenda->organizador,
				'estado'		=> $agenda->estado,
				'idUsuario'		=> $agenda->idUsuario,
				'fchInicio_dia' => $agenda->fchInicio->format('d'),
				'fchInicio_mes' => $agenda->fchInicio->format('m'),
				'fchInicio_hora'=> $agenda->fchInicio->format('H:i')
				);
			$agendas[$key]=$arrayAgenda;
		}

		if(empty($agendas)) $this->responder(false, 'No hay eventos para mostrar');

        $this->responder(true, 'Evento visible', '', $agendas);
	}


}

$ctrl=new ctrlAgenda(true);
?>