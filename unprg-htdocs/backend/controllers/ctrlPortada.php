<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Portada.php';

class ctrlPortada extends abstractController{
	
    protected function init($accion){
        $this->responder(false, "Acciones no implementadas");
    }

 	public function create ($model){
 		$Usuario = $this->checkAccess('portada');

 		$ops=array(
 			'titulo'		=> array('type'=>'string'),
 			'descripcion'	=> array('type'=>'string','min'=>5),
 			'enlace'		=> array('type'=>'string')
 			);
 		$ipts=$this->getFilterInputs('post',$ops);

 		$mysqli=$this->getMysqli();
        $a=array('<','>');
        $b=array('[',']');
 		$port=new Portada($mysqli);
 		$port->titulo 		= $ipts['titulo'];
 		$port->descripcion 	= str_replace($a, $b, $ipts['descripcion']);
 		$port->idUsuario	= $Usuario['id'];
 		$port->ruta 		= $ipts['enlace'];

 		if(!$port->set()){
			$this->responder(false, "No se pudo guardar la portada", $port->md_detalle, null, $mysqli);
        }

        $this->responder(true, "Portada creada!");
	}
	public function update ($model){

	}
	public function delete ($_id){

	}
	public function read ($_id){

	}
	public function readList ($limit, $offset){
		$top = 6; $offset = 0;

        $mysqli = $this->getMysqli();
        $aux = new Portada($mysqli);

        $lista = $aux->search(true);
        if(empty($lista)) $this->responder(false, 'No hay portadas para mostrar');
        $a=array('[',']');
        $b=array('<','>');
        $port = array();

        foreach ($lista as $key => $portada) {
            $port[$key]=$portada->toArray();
            $port[$key]['descripcion']=str_replace($a, $b, $port[$key]['descripcion']);
            
            
        }

        $this->responder(true, 'Avisos obtenidos', '', $port);
	}
}

$ctrl= new ctrlPortada(true);
?>