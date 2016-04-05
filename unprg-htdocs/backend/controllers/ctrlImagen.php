<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';

class ctrlAviso extends abstractController {

    protected function init($accion){
        $this->responder(false, "Acciones no implementadas");
    }

    public function create ($model){
        $Usuario = $this->checkAccess('imagen');

        $ipts=$this->getFilterInputs('post', array(
                'tipo' => array('type'=>'string'),
                'nombre' => array('type'=>'string','min'=>5,'max'=>'45')
            ));

        $tipos = ['aviso','galeria','noticiaCuerpo','noticiaPortada'];
        if(!in_array($ipts['tipo'], $tipos))
            $this->responder(false, 'Tipo de imagen no válido');

        $mysqli = $this->getMysqli();

        if($ipts['tipo']=='galeria'){
            $files = $this->getFilesUpload('archivo',array('image/jpg','image/jpeg','image/png','image/gif'));
            $mysqli->autocommit(false);
            
            
        }else{
            $file = $this->getFileUpload('archivo',array('image/jpg','image/jpeg','image/png','image/gif'));

            $mysqli->autocommit(false);

            $img = new Imagen($mysqli);
            $img->nombre = $this->stripAccents(strtolower(trim($ipts['nombre'])));
            $img->tipo = $ipts['tipo'];
            $img->idUsuario = $Usuario['id'];

            $extension = substr(strrchr($file['type'], "/"), 1);
            $nombre = preg_replace('/[ ]+/', '_', $img->nombre);

            $img->ruta = config::$upload_images.$nombre.'.'.$extension;

            $imgaux = new Imagen($mysqli);
            if($imgaux->getbyNombre($img->nombre))
                $this->responder(false, 'Ya existe una imagen con este nombre');

            if( $img->set() == false)
                $this->responder(false, 'No se pudo guardar la imagen', $img->md_detalle, null, $mysqli);
            

            $rutaArchivo = $_SERVER['DOCUMENT_ROOT'].$img->ruta;
            if(move_uploaded_file($file['tmp'], $rutaArchivo) == false)
                $this->responder(false, "No se pudo guardar imagen", 'Error al almacear la imagen subida', null, $mysqli);

            if( $mysqli->commit() == false)
                $this->responder(false, "No se pudo confirmar cambios", $mysqli->error, null, $mysqli);

            $img->get();

            $this->responder(true, "Imagen creada y guardada", '', $img);

        }
    }
    public function update ($model){
        
    }

    public function delete ($_id){
        
    }

    public function read ($_id){
        
    }

    public function readList ($limit, $offset){
        
    }

    public function stripAccents($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }

}

$ctrl = new ctrlAviso(true);

?>