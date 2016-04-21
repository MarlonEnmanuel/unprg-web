<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Aviso.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Documento.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';

class ctrlAviso extends abstractController {

    protected function init($accion){
        
        switch ($accion) {
            case 'getEmergente': $this->getEmergente(); break;
            default: $this->responder(false, "Acciones no implementadas"); break;
        }
    }



    public function getEmergente(){
        $mysqli = $this->getMysqli();

        $emer = new Aviso($mysqli);

        if( $emer->getEmergente()==false )
            $this->responder(false, 'Error al obtener emergente', $emer->md_detalle);
        
        $this->responder(true, 'Emergente obtenidos', '', $emer);
    }


    public function create(){
        $Usuario = $this->checkAccess('aviso');

        $ipts = $this->getFilterInputs(array(
                    'titulo'        => array('type'=>'string', 'min'=>10, 'max'=>45),
                    'descripcion'   => array('type'=>'string'),
                    'destacado'     => array('type'=>'boolean'),
                    'emergente'     => array('type'=>'boolean'),
                    'estado'        => array('type'=>'boolean'),
                    'tipo'          => array('type'=>'string'),
                    'enlace'        => array('type'=>'string')
                ));

        //Abrir coneccion en modo NO autoconfirmado
        $mysqli = $this->getMysqli();
        $tipo=$ipts['tipo'];
        $link='';

        if($tipo=='link'){
            $link=$ipts['enlace'];
        };
        if($tipo=='images'){
            $img = new Imagen($mysqli);
            $nombb = $this->stripAccents(strtolower(trim($ipts['enlace'])));
            if( $img->getbyNombre($nombb) == false )
                $this->responder(false, 'No existe la <b>imagen</b> con nombre: '.$ipts['enlace']);
            $link=$img->ruta;
        }
        if ($tipo=='documents') {
            $doc = new Documento($mysqli);
            $nombb = trim($ipts['enlace']);
            if( $doc->getbyNombre($nombb) == false )
                $this->responder(false, 'No existe <b>documento</b> con nombre: '.$ipts['enlace']);
            $link = $doc->ruta;
        }


        //Creando el aviso
        $aviso = new Aviso($mysqli);
        $aux= new Aviso($mysqli);

        $aviso->titulo      = $ipts['titulo'];
        $aviso->texto       = $ipts['descripcion'];
        $aviso->destacado   = $ipts['destacado'];
        $aviso->emergente   = $ipts['emergente'];
        $aviso->estado      = $ipts['estado'];
        $aviso->link        = $link;
        $aviso->idUsuario   = $Usuario['id'];

        if($aux->getbyNombre($aviso->titulo)){
            $this->responder(false,"Ya existe un aviso con el nombre: ".$aviso->titulo);
        }

        if(!$aviso->set()) { //Insertando el aviso
            $this->responder(false, "No se pudo guardar el aviso", $aviso->md_detalle, null, $mysqli);
        }

        $this->responder(true, "Aviso creado!");
    }


    public function update(){
        $Usuario = $this->checkAccess('aviso');

        $ipts = $this->getFilterInputs(array(
                    'id'            => array('type'=>'int'),
                    'titulo'        => array('type'=>'string'),
                    'descripcion'   => array('type'=>'string'),
                    'destacado'     => array('type'=>'boolean'),
                    'emergente'     => array('type'=>'boolean'),
                    'estado'        => array('type'=>'boolean')

                ));
    
        $mysqli = $this->getMysqli();
        

        $aviso = new Aviso($mysqli, $ipts['id']);
        $aux    = new Aviso($mysqli);

        if($aviso->get() == false){
            $this->responder(false, 'El aviso no existe');
        }

        if($aviso->idUsuario!=$Usuario['id'] && !$this->isAdmin()){
            $this->responder(false, 'Este aviso fue creado por otro usuario, no tiene permisos para modificarlo');
        }

        if($aux->getbyNombre($ipts['titulo'])){
            if($aux->idAviso !== $aviso->idAviso){
                $this->responder(false, "Ya existe un aviso con el titulo: ".$aviso->titulo);
            }
        }


        $aviso->titulo      = $ipts['titulo'];
        $aviso->texto       = $ipts['descripcion'];
        $aviso->destacado   = $ipts['destacado'];
        $aviso->emergente   = $ipts['emergente'];
        $aviso->estado      = $ipts['estado'];
        $aviso->idUsuario   = $Usuario['id'];
        $aviso->id          = $ipts['id'];

        

        if(!$aviso->edit()) { //Insertando el aviso
            $this->responder(false, "No se pudo editar el aviso", $aviso->md_detalle, null, $mysqli);
        }

        $this->responder(true, "Aviso editado!",'',$aviso->toArray());

    }


    public function delete(){
        $Usuario = $this->checkAccess('aviso');

        $ipts = $this->getFilterInputs(array(
                    '_id' => array('type'=>'int','min'=>1),
                ));

        

        $mysqli = $this->getMysqli();
        $aviso = new Aviso($mysqli, $ipts['_id'] );

        

        if($aviso->get() == false){
            $this->responder(false, 'El aviso no existe');
        }

        if($aviso->id != $Usuario['id'] && !$this->isAdmin()){
            $this->responder(false, 'Este aviso fue creado por otro usuario, no tiene permisos para modificarlo');
        }


        if(!$aviso->delete()){
            $this->responder(false, "No se pudo eliminar el aviso", $aviso->md_detalle, null, $mysqli);
        }

        $this->responder(true, "Aviso eliminado!",'',array('status'=>'ok'));
    }


    public function read(){
        
    }


    public function readList(){
        $top = 6; $offset = 0;

        $mysqli = $this->getMysqli();
        $aux = new Aviso($mysqli);

        $lista = $aux->search(true,$top);
        if(empty($lista)) $this->responder(false, 'No hay documentos para mostrar');
        $avisos = array();

        foreach ($lista as $key => $aviso) {
            $avisos[$key]=$aviso->toArray();
            $avisos[$key]['fchReg'] = $avisos[$key]['fchReg']->format(config::$date_fecha);
            
        }

        $this->responder(true, 'Avisos obtenidos', '', $avisos);
    }


    public function readAll(){
        $Usuario=$this->checkAccess('aviso');

        $_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
        $_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

        $mysqli = $this->getMysqli();

        $aux = new Aviso($mysqli);

        $lista = $aux->search(false, $_limit, $_offset);

        $avisos = array();
        foreach ($lista as $key => $aviso) {
            $user = new Usuario($mysqli, $aviso->idUsuario);
            $user->get();
            $avisos[$key] = $aviso->toArray();
            $avisos[$key]['usuario'] = $user->email;
        }

        $this->responder(true, 'avisos obtenidos', '', $avisos);
    }

}

$ctrl = new ctrlAviso(true);

?>