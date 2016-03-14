<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of absModel
 *
 * @author Enmanuel
 */
class abstractModel {
    
    protected $mysqli;      //Mysqli cado para mysql
    
    public $md_estado;      //Estado del modelo
    public $md_mensaje;     //Mensaje para un procedimiento
    public $md_detalle;     //Detalle del procedimiento

    public $id;             //Todo modelo tiene un id

    /**
    * Constructor para cada modelo
    *
    * Se debe indicar la concción a la BD, opcionalmente se puede indicar el ID del
    * modelo para su posterior búsqueda con la función get
    *
    * @param $mysqli Conección pasado por referencia
    * @param $id Identificador del modelo (opcional)
    */
    public function __construct(&$mysqli, $id=null){
        $this->mysqli = &$mysqli;
        if(isset($id)) $this->id = $id;
    }

    public final function checkMysqli(){
        if($this->mysqli->connect_errno || $this->mysqli->errno){
            $this->md_estado = false;
            if($this->mysqli->connect_errno){
                $this->md_mensaje = "Error de conección (modelo)";
                if(config::$isDebugging===true) $this->md_detalle = $mysqli->connect_error;
            }else{
                $this->md_mensaje = "Error en la BD (modelo)";
                if(config::$isDebugging===true) $this->md_detalle = $mysqli->error;
            }
            return false;
        }
        return true;
    }
    
    /**
    * Convierte un modelo en una cadena con formato json
    *
    * Convierte el modelo a formato json, todos los caracteres deben tener 
    * cotejamiento UTF-8 de los contrario la función fallará y devolverá false
    *
    * @param $campos Un array indicando los campos que se desean combertir, si se pasa null o un array vació se combierten todos los campos
    * @return String Una cadena en formato json
    */
    public final function toJSON($campos=null){
        return json_encode($this->toArray($campos));
    }
    
    /**
    * Convierte un modelo en un array asociativo
    *
    * @param $campos Un array indicando los campos que se desean combertir, si se pasa null o un array vació se combierten todos los campos
    * @return Array el array asociativo
    */
    public final function toArray($campos=null){
        $filtrar = isset($campos) && count($campos)>0;
        $model = get_object_vars($this);
        $array = array();
        foreach ($model as $campo=>$valor){
            if($campo!='mysqli' && substr($campo,0,3)!='md_'){
                if($filtrar){
                    if(in_array($campo, $campos)){
                        $array[$campo] = $valor;
                    }
                }else{
                    $array[$campo] = $valor;
                }
            }
        }
        return $array;
    }
}