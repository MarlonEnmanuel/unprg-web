<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Aviso.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Imagen.php';

class ctrlAviso extends abstractController {

    protected function init($accion){
        
        if($accion == 'getVisibles'){   //acción del controlador
            $this->getVisibles();
        }else{                          //responde cuando la acción no corresponde a ningun controlador
            $this->responder(false, "Acción no soportada");
        }

    }
    public function create ($model){
        
    }
    public function update ($model){
        
    }
    public function delete ($_id){
        
    }
    public function read ($_ruta){
        $mysqli=$this->getMysqli();
        $ruta=$_ruta;
        $aux=new Imagen($mysqli);

        $lista=$aux->searchLink($ruta);

        if(empty($lista)) $this->responder(false, 'No hay imagenes para mostrar');

        $img=array();
        foreach ($lista as $key => $images) {
                $img[$key]=$images->toArray();
                $img[$key]['fchReg']=$img[$key]['fchReg']->format(config::$date_fecha);
        }
        $this->responder(true,'Imagen visible','',$img);
    }
    public function readList ($limit, $offset){
        
    }
}

$ctrl = new ctrlAviso(true);

?>