<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Galeria.php';

class ctrlImagen extends abstractController {

    protected function init($accion){
        switch ($accion) {
            case 'readTipo': $this->readTipo(); break;
            default: $this->responder(false, "Acciones no implementadas"); break;
        }
    }


    public function create (){
        $Usuario = $this->checkAccess('imagen');

        $ipts=$this->getFilterInputs(array(
                'tipo' => array('type'=>'string'),
                'nombre' => array('type'=>'string','min'=>5,'max'=>'45')
            ));

        $tipos = ['aviso','galeria','noticiaCuerpo','noticiaPortada', 'portada'];
        if(!in_array($ipts['tipo'], $tipos))
            $this->responder(false, 'Tipo de imagen no válido');

        $mysqli = $this->getMysqli();
        $mysqli->autocommit(false);

        if($ipts['tipo']=='galeria'){
            $files = $this->getFilesUpload('archivo',array('image/jpg','image/jpeg','image/png','image/gif'));
            
            $galeria = new Galeria($mysqli);
            $galeria->nombre = $this->stripAccents(strtolower(trim( $ipts['nombre'] )));
            $img->titulo     = $ipts['nombre'];
            $img->descripcion= ''; //Corregir luego

            $galaux = new Galeria($mysqli);
            if($galaux->getbyNombre($galeria->nombre))
                $this->responder(false, 'Ya existe una galería con este nombre', '', null, $mysqli);

            if($galeria->set()==false)
                $this->responder(false, "Error al insertar la galería", '', null, $mysqli);


            foreach ($files as $key => $file) {
                $img = new Imagen($mysqli);
                $img->nombre    = 'gal-'.$galeria->nombre.'-'.$key;
                $img->tipo      = 'galeria';
                $img->version   = 0;
                $img->idUsuario = $Usuario['id'];
                $img->idGaleria = $galeria->id;

                $extension = substr(strrchr($file['type'], "/"), 1);
                $nombre = preg_replace('/[ ]+/', '_', $img->nombre);
                $img->ruta = config::$upload_images.$nombre.'.'.$extension;

                if( $img->set() == false)
                    $this->responder(false, 'No se pudo guardar la imagen', $img->md_detalle, null, $mysqli);

                $rutaArchivo = $_SERVER['DOCUMENT_ROOT'].$img->ruta;
                if(move_uploaded_file($file['tmp'], $rutaArchivo) == false)
                    $this->responder(false, "No se pudo almacenar imagen", 'Error al almacear la imagen subida', null, $mysqli);

                array_push($galeria->imagenes, $img);
            }

            if( $mysqli->commit() == false)
                $this->responder(false, "No se pudo confirmar cambios", $mysqli->error, null, $mysqli);

            $this->responder(true, "Imagen creada y guardada", '', $galeria);
            
        }else{
            $file = $this->getFileUpload('archivo',array('image/jpg','image/jpeg','image/png','image/gif'));

            $img = new Imagen($mysqli);
            $img->nombre    = $this->stripAccents(strtolower(trim($ipts['nombre'])));
            $img->tipo      = $ipts['tipo'];
            $img->version   = 0;
            $img->idUsuario = $Usuario['id'];

            $extension = substr(strrchr($file['type'], "/"), 1);
            $nombre = preg_replace('/[ ]+/', '_', $img->nombre);

            $img->ruta = config::$upload_images.$nombre.'.'.$extension;

            $imgaux = new Imagen($mysqli);
            if($imgaux->getbyNombre($img->nombre))
                $this->responder(false, 'Ya existe una imagen con este nombre', '', null, $mysqli);

            if( $img->set() == false)
                $this->responder(false, 'No se pudo guardar la imagen', $img->md_detalle, null, $mysqli);
            

            $rutaArchivo = $_SERVER['DOCUMENT_ROOT'].$img->ruta;
            if(move_uploaded_file($file['tmp'], $rutaArchivo) == false)
                $this->responder(false, "No se pudo guardar imagen", 'Error al almacear la imagen subida', null, $mysqli);

            if( $mysqli->commit() == false)
                $this->responder(false, "No se pudo confirmar cambios", $mysqli->error, null, $mysqli);

            $this->responder(true, "Imagen creada y guardada", '', $img);

        }
    }


    public function update (){
        
    }


    public function delete (){
        
    }


    public function read (){
        
    }


    public function readList (){
        
    }


    public function readTipo(){
        $mysqli = $this->getMysqli();
        $aux=new Imagen($mysqli);

        $Tipo = $this->getFilterInputs("get",array(
            'tipo'=>array('type'=>'string')
            ));
        
        $tipo=$Tipo['tipo'];
        

        $lista = $aux->searchtipo($tipo);

        if(empty($lista)) $this->responder(false, 'No hay imagenes para mostrar');

        $imagenes=array();
        foreach ($lista as $key => $images) {
            $imagenes[$key]=$images->toArray();
            $imagenes[$key]['fchReg'] = $imagenes[$key]['fchReg']->format(config::$date_fecha);
        }
        $this->responder(true, 'Imagenes obtenidas', '', $imagenes);
    }

}

$ctrl = new ctrlImagen(true);

?>