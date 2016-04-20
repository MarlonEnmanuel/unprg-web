<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Documento.php';

class ctrlDocumento extends abstractController{
	
	protected function init($accion){
		if($accion == 'getVisibles'){   //acción del controlador
            $this->getVisibles();

        }elseif($accion == 'nuevoDocumento'){         //acción del controlador
            $this->nuevoDocumento();

        }elseif($accion == ''){         //acción del controlador


        }elseif($accion == ''){         //acción del controlador


        }else{                          //responde cuando la acción no corresponde a ningun controlador
            $this->responder(false, "Acción no soportada");
        }
	}


	public function readList(){
		$mysqli = $this->getMysqli();

        $vi=3;
        $fi=0;
        $aux = new Documento($mysqli);
        
        $lista = $aux->search();
        if(empty($lista)) $this->responder(false, 'No hay documentos para mostrar');

        $documentos = array();
        foreach ($lista as $key => $document) {
        	$documentos[$key] = $document->toArray();
            $documentos[$key]['fchReg'] = $documentos[$key]['fchReg']->format('U');
        }

        $this->responder(true, 'Documento visible', '', $documentos);

	}


    public function create (){
        $Usuario = $this->checkAccess('documento');

        $ipts = $this->getFilterInputs(array(
            'nombre'    => array('type'=>'string'),
            'tipo'      => array('type'=>'string')
        ));

        $file = $this->getFileUpload('archivo',array('application/pdf'));

        $mysqli=$this->getMysqli();

        $mysqli->autocommit(false);

        $doc = new Documento($mysqli);
        $doc->nombre        = trim($ipts['nombre']);
        $doc->ruta          = '';
        $doc->tipo          = $ipts['tipo'];
        $doc->version       = 0;
        $doc->idUsuario     = $Usuario['id'];

        $extension = substr(strrchr($file['type'], "/"), 1);
        $nombre = preg_replace('/[ ]+/', '_', $this->stripAccents(strtolower(trim($ipts['nombre']))));

        $doc->ruta = config::$upload_documents.$nombre.'.'.$extension;

        $docaux = new Documento($mysqli);
        if($docaux->getbyNombre($doc->nombre))
            $this->responder(false, 'Ya existe un documento con este nombre', '', null, $mysqli);

        if( $doc->set() == false)
            $this->responder(false, 'No se pudo guardar el documento', $doc->md_detalle, null, $mysqli);

        $rutaArchivo = $_SERVER['DOCUMENT_ROOT'].$doc->ruta;
        if(move_uploaded_file($file['tmp'], $rutaArchivo) == false)
            $this->responder(false, "No se pudo guardar el documento", 'Error al almacenar el documento subido', null, $mysqli);

        if( $mysqli->commit() == false)
            $this->responder(false, "No se pudo confirmar cambios", $mysqli->error, null, $mysqli);

        $this->responder(true, "Documento creado y guardado", '', $doc);

    }


    public function update (){

    }


    public function delete (){

    }


    public function read (){

    }

	
    public function readAll(){
        
    }

}

$ctrl=new ctrlDocumento(true);

?>