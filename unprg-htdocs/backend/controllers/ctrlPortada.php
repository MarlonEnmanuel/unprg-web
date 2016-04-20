<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Portada.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';

class ctrlPortada extends abstractController{
	
    protected function init($accion){
        $this->responder(false, "Acciones no implementadas");
    }


 	public function create (){
 		$Usuario = $this->checkAccess('portada');

 		$ipts = $this->getFilterInputs(array(
                    'titulo'        => array('type'=>'string', 'max'=>100),
                    'descripcion'   => array('type'=>'string'),
                    'enlace'        => array('type'=>'string')
                ));

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

        $this->responder(true, "Portada creada!",'',$port->toArray());
	}


	public function update (){
        $Usuario=$this->checkAccess('portada');

        $ipts=$this->getFilterInputs(array(
            'id'            => array('type'=>'int', 'min'=>1),
            'titulo'        => array('type'=>'string', 'max'=>100),
            'descripcion'   => array('type'=>'string'),
            'estado'        => array('type'=>'boolean')
            ));

        $mysqli=$this->getMysqli();

        $portada    =   new Portada($mysqli, $ipts['id']);
        $aux        =   new Portada($mysqli);

        if($portada->get() == false){
            $this->responder(false, 'La portada no existe');
        }

        if($portada->idUsuario!=$Usuario['id'] && !$this->isAdmin()){
            $this->responder(false, 'Esta portada fue creado por otro usuario, no tiene permisos para modificarlo');
        }
        if($aux->getbyNombre($ipts['titulo'])){
            
            if($aux->idPortada !== $portada->id){
                $this->responder(false, "Ya existe un portada con el nombre: ".$portada->titulo);
            }
        }
        $portada->titulo        = $ipts['titulo'];
        $portada->descripcion   = $ipts['descripcion'];
        $portada->estado        = $ipts['estado'];

        if($portada->edit() == false) {
            $this->responder(false, "No se pudo actualizar el portada", $portada->md_detalle);
        }

        $this->responder(true, "Portada actualizado!", '', $portada->toArray());
	}


	public function delete (){
        $Usuario=$this->checkAccess('portada');

        $ipts = $this->getFilterInputs(array(
                    '_id' => array('type'=>'int', 'min'=>1)
                ));

        $mysqli=$this->getMysqli();

        $portada = new Portada($mysqli, $ipts['_id']);

        if($portada->get() == false){
            $this->responder(false, 'El portada no existe');
        }

        if($portada->id != $Usuario['id'] && !$this->isAdmin()){
            $this->responder(false, 'Este portada fue creado por otro usuario, no tiene permisos para modificarlo');
        }

        if($portada->delete() == false) {
            $this->responder(false, "No se pudo eliminar el portada", $portada->md_detalle);
        }

        $this->responder(true, "Portada eliminada!", '', array('status'=>'ok'));
	}


	public function read (){

	}


    public function readList (){

        $mysqli = $this->getMysqli();

        $_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
        $_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

        $aux = new Portada($mysqli);

        $lista = $aux->search(true,$_limit,$_offset);
        if(empty($lista)) $this->responder(true, 'No hay portadas para mostrar');
        $a=array('[',']');
        $b=array('<','>');
        $port = array();

        foreach ($lista as $key => $portada) {
            $port[$key]=$portada->toArray();
            $port[$key]['descripcion']=str_replace($a, $b, $port[$key]['descripcion']);
        }

        $this->responder(true, 'Portadas obtenidos', '', $port);
	}


    public function readAll(){
        $Usuario=$this->checkAccess('portada');
        
        
        $_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
        

        $mysqli = $this->getMysqli();


        $aux = new Portada($mysqli);

        $lista = $aux->search(false,$_limit);
        
        $a=array('[',']');
        $b=array('<','>');
        $port = array();

        foreach ($lista as $key => $portada) {
            $user = new Usuario($mysqli, $portada->idUsuario);
            $user->get();
            $port[$key]=$portada->toArray();
            $port[$key]['descripcion']=str_replace($a, $b, $port[$key]['descripcion']);
            $port[$key]['usuario'] = $user->email;
        }

        $this->responder(true, 'Portadas obtenidos', '', $port);
    }
    

}

$ctrl= new ctrlPortada(true);
?>