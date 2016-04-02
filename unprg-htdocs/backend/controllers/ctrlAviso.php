<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Aviso.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';

class ctrlAviso extends abstractController {

    protected function init($accion){
        
        if($accion == 'getVisibles'){   //acción del controlador
            $this->getVisibles();

        }elseif($accion == 'nuevoAviso'){         //acción del controlador
            $this->nuevoAviso();

        }elseif($accion == ''){         //acción del controlador


        }elseif($accion == ''){         //acción del controlador


        }else{                          //responde cuando la acción no corresponde a ningun controlador
            $this->responder(false, "Acción no soportada");
        }
    }

    protected function getVisibles() {
        $mysqli = $this->getMysqli();
        
        $aux = new Aviso($mysqli);
        $lista = $aux->searchVisible();
        $avisos = array();

        foreach ($lista as $key => $aviso) {
            $imagen = new Imagen($mysqli,$aviso->idImagen);
            $imagen->get();
            $arrayAviso = array(
                'id'        => $aviso->id,
                'fecha'     => $aviso->fchReg->format(config::$date_aviso),
                'titulo'    => $aviso->titulo,
                'texto'     => $aviso->texto,
                'destacado' => $aviso->destacado,
                'emergente' => $aviso->emergente,
                'estado'    => $aviso->estado,
                'link'      => $aviso->link,
                'ruta'      => $imagen->ruta,
                'nombre'    => $imagen->nombre
            );
            $avisos[$key] = $arrayAviso;
        }

        if(empty($avisos)) $this->responder(false, 'No hay avisos para mostrar');

        $this->responder(true, 'Avisos visible', '', $avisos);
    }

    protected function nuevoAviso(){
        
        $Usuario = $this->checkAccess('aviso');

        $ops = array(
            'titulo'        => array('type'=>'string'),
            'descripcion'   => array('type'=>'string', 'min'=>12),
            'destacado'     => array('type'=>'boolean'),
            'emergente'     => array('type'=>'boolean'),
            'estado'        => array('type'=>'boolean'),
            'enlace'        => array('type'=>'string'),
            'nombre'        => array('type'=>'string', 'min'=>5, 'max'=>45)
        );

        $file;
        $ipts=$this->getFilterInputs('post',$ops);


        $file=$this->getFileUpload('archivo',array('image/jpeg','image/png','image/jpg'));

        //Abrir coneccion en modo NO autoconfirmado
        $mysqli = $this->getMysqli();
        
        $mysqli->autocommit(false);

        //Creando la imagen
        $imagen = new Imagen($mysqli);
        $imagen->nombre    = $ipts['nombre'];
        $imagen->ruta      = '';

        if(!$imagen->set()) { //Insertar imagen
            $this->responder(false, 'No se pudo insertar imagen', $imagen->md_detalle, $ipts, $mysqli);
        }

        //Crear el nombre a partir del id de la imagen
        $nombre = md5($imagen->id).'.'.substr(strrchr($file['type'], "/"), 1);

        //Actualizar ruta de la imagen
        $imagen->ruta = config::$upload_images.$nombre;
        if(!$imagen->edit()) {
            $this->responder(false, 'No se pudo insertar imagen (ruta)', $imagen->md_detalle, null, $mysqli);
        }

        //Creando el aviso
        $aviso = new Aviso($mysqli);
        $aviso->titulo      = $ipts['titulo'];
        $aviso->texto       = $ipts['descripcion'];
        $aviso->destacado   = $ipts['destacado'];
        $aviso->emergente   = $ipts['emergente'];
        $aviso->estado      = $ipts['estado'];
        $aviso->link        = $ipts['enlace'];
        $aviso->idUsuario   = $Usuario['id'];
        $aviso->idImagen    = $imagen->id;

        if(!$aviso->set()) { //Insertando el aviso
            $this->responder(false, "No se pudo guardar el aviso", $aviso->md_detalle, null, $mysqli);
        }

        //Guardando imagen o documento
        $rutaNueva = $_SERVER['DOCUMENT_ROOT'].$imagen->ruta;
        if(!move_uploaded_file($file['tmp'], $rutaNueva)){
            $this->responder(false, "No se pudo guardar imagen", 'Error al almacear la imagen subida', null, $mysqli);
        }

        if(!$mysqli->commit()){
            $this->responder(false, "No se pudo confirmar cambios", $mysqli->error, null, $mysqli);
        }

        $this->responder(true, "Aviso creado!", "redirect", '/');

    }

}

$ctrl = new ctrlAviso(true);

?>