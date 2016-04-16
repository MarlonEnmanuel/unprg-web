<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Portada.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';

class ctrlPortada extends abstractController{
	
    protected function init($accion){
        $this->responder(false, "Acciones no implementadas");
    }

 	public function create (){
 		$Usuario = $this->checkAccess('portada');

 		$ops=array(
 			'titulo'		=> array('type'=>'string', 'max'=>100),
 			'descripcion'	=> array('type'=>'string'),
 			'enlace'		=> array('type'=>'string')
 			);
 		$ipts=$this->getFilterInputs($ops);

 		$mysqli=$this->getMysqli();
        $a=array('<','>');
        $b=array('[',']');
 		$port=new Portada($mysqli);
 		$port->titulo 		= $ipts['titulo'];
 		$port->descripcion 	= str_replace($a, $b, $ipts['descripcion']);
 		$port->idUsuario	= $Usuario['id'];
 		$port->ruta 		= $ipts['enlace'];

        $img = new Imagen($mysqli);
        if(!$img->getbyNombre($port->ruta))
            $this->responder(false, "No existe la imagen: ".$port->ruta, $port->md_detalle);
        $port->idImagen = $img->id;

 		if(!$port->set())
			$this->responder(false, "No se pudo guardar la portada", $port->md_detalle);

        $this->responder(true, "Portada creada!");
	}

	public function update (){

	}

	public function delete (){

	}

	public function read (){

	}

	public function readList (){
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

        $this->responder(true, 'Portadas obtenidos', '', $port);
	}

}

$ctrl= new ctrlPortada(true);
?>