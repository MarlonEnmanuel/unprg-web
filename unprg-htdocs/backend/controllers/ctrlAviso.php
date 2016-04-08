<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Aviso.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';

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


    public function create($model){
        $Usuario = $this->checkAccess('aviso');

        $ops = array(
            'titulo'        => array('type'=>'string'),
            'descripcion'   => array('type'=>'string', 'min'=>12),
            'destacado'     => array('type'=>'boolean'),
            'emergente'     => array('type'=>'boolean'),
            'estado'        => array('type'=>'boolean'),
            'tipo'          => array('type'=>'string'),
            'enlace'        => array('type'=>'string')
        );
        $ipts=$this->getFilterInputs('post',$ops);
        //Abrir coneccion en modo NO autoconfirmado
        $mysqli = $this->getMysqli();
        $url='/uploads/';
        
        //Creando el aviso
        $aviso = new Aviso($mysqli);
        $aviso->titulo      = $ipts['titulo'];
        $aviso->texto       = $ipts['descripcion'];
        $aviso->destacado   = $ipts['destacado'];
        $aviso->emergente   = $ipts['emergente'];
        $aviso->estado      = $ipts['estado'];
        $aviso->link        = $url.$ipts['tipo'].'/'.$ipts['enlace'];
        $aviso->idUsuario   = $Usuario['id'];

        if(!$aviso->set()) { //Insertando el aviso
            $this->responder(false, "No se pudo guardar el aviso", $aviso->md_detalle, null, $mysqli);
        }


        $this->responder(true, "Aviso creado!");
    }

    public function update($model){
        $this->responder(false, 'Método no soportado');
    }

    public function patch($model){
        $this->responder(false, 'Método no soportado');
    }

    public function delete($model){
        $this->responder(false, 'Método no soportado');
    }

    public function read($idtoRead){
        $this->responder(false, 'Método no soportado');
    }

    public function readList($top, $offset){
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

}

$ctrl = new ctrlAviso(true);

?>