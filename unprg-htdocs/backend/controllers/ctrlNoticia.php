<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Noticia.php';
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
    		'titulo' 		=> array('type'=>'string'),
    		'principal'		=> array('type'=>'string'),
    		'json' 			=> array('type'=>'string'),
    		'extras'		=> array('type'=>'string'),
    		'galeria' 		=> array('type'=>'string'),
            'estado'        => array('type'=>'boolean'),
            'destacado'     => array('type'=>'boolean'),
    		));

    	$mysqli=$this->getMysqli();
        $j=$ipts['json'];

    	$noticia= new Noticia($mysqli);
    	$aux= new Noticia($mysqli);

    	$noticia->titulo		= $ipts['titulo'];
    	$noticia->json 			= $ipts['json'];
    	$noticia->extras		= $ipts['extras'];
    	$noticia->idUsuario		= $Usuario['id'];
    	$noticia->principal		= $ipts['principal'];
    	$noticia->galeria 		= $ipts['galeria'];
        $noticia->estado        = $ipts['estado'];
        $noticia->destacado     = $ipts['destacado'];

    	//Obtiene el id de la Imagen Portada
    	$img = new Imagen($mysqli);
        if(!$img->getbyNombre($ipts['principal']))
            $this->responder(false, "No existe la imagen: ".$noticia->principal, $noticia->md_detalle);

        //Obtiene el id de la Galeria
        $gal= new Galeria($mysqli);
        if(!$gal->getbyNombre($ipts['galeria']))
        	$this->responder(false,"No existe una galeria: ".$noticia->galeria,$noticia->md_detalle);


        $noticia->idImagen		= $img->id;
    	$noticia->idGaleria 	= $gal->id;

    	if($aux->getbyNombre($noticia->titulo)){
    		$this->responder(false,"Ya existe una noticia con el titulo: ".$noticia->titulo);
    	}

    	if(!$noticia->set()){
    		$this->responder(false,"No se pudo guardar la noticia",$noticia->md_detalle);
    	}

    	$this->responder(true,"Noticia creada!","",$noticia->toArray());

    }

    public function update(){
    	$Usuario=$this->checkAccess('noticia');

    	$ipts=$this->getFilterInputs(array(
    		'id' 		=> array('type'=>'int'),
    		'titulo' 	=> array('type'=>'string'),
    		'json' 		=> array('type'=>'string'),
    		'extra' 	=> array('type'=>'string'),
    		'estado' 	=> array('type'=>'boolean'),
            'destacado' => array('type'=>'boolean' )
    		));

    	$mysqli=$this->getMysqli();
        
	   	$noticia= new Noticia($mysqli,$ipts['id']);
    	$aux= new Noticia($mysqli);

    	if($noticia->get()==false){
    		$this->responder(false,'La Noticia no existe');
    	}

    	if($noticia->idUsuario!=$Usuario['id'] && !$this->isAdmin()){
    		$this->responder(false,'Esta noticia fue creada por otro usuario, no tiene permisos para modificarlo');
    	}

    	if($aux->getbyNombre($ipts['titulo'])){
    		if($aux->id !== $noticia->id){
    			$this->responder(false,"Ya existe una noticia con el titulo: ".$noticia->titulo);
    		}
    	}

    	$noticia->titulo 		= $ipts['titulo'];
    	$noticia->json 			= $ipts['json'];
    	$noticia->extras 		= $ipts['extra'];
    	$noticia->estado		= $ipts['estado'];
        $noticia->destacado     = $ipts['destacado'];

    	if($noticia->edit()==false){
    		$this->responder(false,"No se pudo actualizar la noticia",$noticia->md_detalle);
    	}

    	$this->responder(true,"Noticia actualizada!",'',$noticia->toArray());



    } 	

	public function delete(){
		$Usuario=$this->checkAccess('noticia');

        $ipts = $this->getFilterInputs(array(
                    '_id' => array('type'=>'int', 'min'=>1)
                ));

        $mysqli=$this->getMysqli();

        $noticia = new Noticia($mysqli, $ipts['_id']);

        if($noticia->get() == false){
            $this->responder(false, 'La noticia no existe');
        }

        if($noticia->id != $Usuario['id'] && !$this->isAdmin()){
            $this->responder(false, 'Esta noticia fue creado por otro usuario, no tiene permisos para modificarlo');
        }

        if($noticia->delete() == false) {
            $this->responder(false, "No se pudo eliminar la noticia", $noticia->md_detalle);
        }

        $this->responder(true, "Noticia eliminada!", '', array('status'=>'ok'));
	}

	public function read(){

	}

	public function readList(){
		$mysqli = $this->getMysqli();

        $_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
        $_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

        $aux = new Noticia($mysqli);

        $lista = $aux->search(true,$_limit,$_offset);
        if(empty($lista)) $this->responder(true, 'No hay noticias para mostrar');
        $not = array();

        
        foreach ($lista as $key => $noticia) {
            $not[$key]=$noticia->toArray();
            $id=$not[$key]['idImagen'];
            $img = new Imagen($mysqli,$id);
            $img->get();
            $not[$key]['ruta']=$img->ruta;
            

        }

        $this->responder(true, 'Noticias obtenidas', '', $not);
	}


    public function readAll(){
        $Usuario=$this->checkAccess('noticia');

		$_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
		$_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

		$mysqli = $this->getMysqli();

        $aux = new Noticia($mysqli);

        $lista = $aux->search(false, $_limit, $_offset);

        $not = array();
        foreach ($lista as $key => $noticia) {
        	$user = new Usuario($mysqli, $noticia->idUsuario);
        	$user->get();
            $not[$key] = $noticia->toArray();
            $not[$key]['usuario'] = $user->email;
            
        }

        $this->responder(true, 'noticias obtenidas', '', $not);
    }
    

}

$ctrl= new ctrlNoticia(true);
?>