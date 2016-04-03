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

	protected function getVisibles(){
		$mysqli = $this->getMysqli();
        $vi=3;
        $fi=0;
        $aux = new Documento($mysqli);
        
        $lista = $aux->search();
        $document = array();
        foreach ($lista as $key => $documentos) {
        	$arrayDoc=array(
        		'id'		=> $documentos->id,
        		'fecha'		=> $documentos->fchReg->format(config::$date_aviso),
        		'nombre'	=> $documentos->nombre,
        		'ruta'		=> $documentos->ruta,
        		'tipo'		=> $documentos->tipo,
        		'validacion'=> $documentos->validacion,
        		'idUsuario'	=> $documentos->idUsuario
        		);
        	$document[$key]=$arrayDoc;
        }
        if(empty($document)) $this->responder(false, 'No hay documentos para mostrar');

        $this->responder(true, 'Documento visible', '', $document);

	}

	protected function nuevoDocumento(){
		$Usuario = $this->checkAccess('documentos');

		$ipts = $this->getFilterInputs('post', array(
			'nombre'	=> array('type'=>'string'),
			'tipo'		=> array('type'=>'string')
		));

		$file = $this->getFileUpload('archivo',array('application/pdf'));

		$mysqli=$this->getMysqli();

		$mysqli->autocommit(false);

		$doc = new Documento($mysqli);
		$doc->nombre		= $ipts['nombre'];
		$doc->ruta 			= '.l.';
		$doc->tipo			= $ipts['tipo'];
		$doc->idUsuario		= $Usuario['id'];


		if( $doc->set() == false ){
			$this->responder(false, "No se pudo guardar el documentos", $doc->md_detalle, null, $mysqli);
		}


        $doc->get();

        $nombre = $doc->nombre.'.pdf';
        $doc->ruta = config::$upload_documents.$nombre;

        if(!$doc->edit()){
        	$this->responder(false,'No se pudo insertar documento(ruta)',$doc->md_detalle,null,$mysqli);
        }

		$rutaNueva = $_SERVER['DOCUMENT_ROOT'].$doc->ruta;
        if(!move_uploaded_file($file['tmp'], $rutaNueva)){
            $this->responder(false, "No se pudo guardar imagen", 'Error al almacear la imagen subida', null, $mysqli);
        }

        if( $mysqli->commit()==false){
            $this->responder(false, "No se pudo confirmar cambios", $mysqli->error, null, $mysqli);
        }

		$this->responder(true, "Documento creado!");





	}

}

$ctrl=new ctrlDocumento(true);

?>