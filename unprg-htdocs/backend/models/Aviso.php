<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';



class Aviso extends abstractModel{

	public $fchReg;
    public $titulo;
	public $texto;
	public $destacado;
	public $emergente;
    public $link;
	public $estado;
	public $idUsuario;


    public function get(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
        $sql = "select * from aviso where idAviso=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(    
            $this->idAviso,
            $this->fchReg,
            $this->titulo,
            $this->texto,
            $this->destacado,
            $this->emergente,
            $this->link,
            $this->estado,
            $this->idUsuario
            );
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Aviso obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Aviso";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }


    public function set(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli
        if(isset($this->id)){   //si tiene ID entonces ya existe en la BD
            $this->md_mensaje = "El usuario ya tiene id";
            return $this->md_estado = false;
        }

        $sql = "INSERT INTO aviso (titulo, texto, destacado, emergente, link, idUsuario) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ssiisi',
            $this->titulo,
            $this->texto,
            $this->destacado,
            $this->emergente,
            $this->link,
            $this->idUsuario
            );
        if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Aviso insertado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar aviso";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        if($this->md_estado) $this->get();
        return $this->md_estado;
    }


    public function edit(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder editar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
        $sql = "UPDATE aviso SET titulo=?, texto=?, destacado=?, emergente=?, estado=? WHERE idAviso=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);

        $stmt->bind_param('ssiiii',
            $this->titulo,
            $this->texto,
            $this->destacado,
            $this->emergente,
            $this->estado,
            $this->id
            );
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Aviso actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar aviso";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }


    public function delete(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder eliminar
            $this->md_mensaje = "Debe indicar un id para eliminar";
            return $this->md_estado = false;
        }
        
        $sql = "DELETE FROM aviso WHERE idAviso=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $this->id);
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Aviso eliminado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al eliminar aviso";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }


    public function search($active=false, $limit=null, $offset=null){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM aviso ";

        if($active){
            $sql .= "WHERE estado=1 ";
        }

        $sql .= " ORDER BY fchReg DESC ";

        if(is_int($limit) && $limit>=1 ){
            $sql .= " LIMIT ".$limit;
            if(is_int($offset) && $offset>=1)
                $sql .= " OFFSET ".$offset;
        }

        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->execute();
        $stmt->bind_result(
            $_id,
            $_fchReg,
            $_titulo,
            $_texto,
            $_destacado,
            $_emergente,
            $_link,
            $_estado,
            $_idUsuario
            );
        $list=array();
        while ($stmt->fetch()) {
            $avi=new Aviso($this->mysqli);
            $avi->id        = $_id;
            $avi->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $avi->titulo    = $_titulo;
            $avi->texto     = $_texto;
            $avi->destacado = $_destacado;
            $avi->emergente = $_emergente;
            $avi->link      = $_link;
            $avi->estado    = $_estado;
            $avi->idUsuario = $_idUsuario;
            array_push($list, $avi);
        }
        $stmt->close();

        return $list;
    }

    public function getEmergente(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM aviso where emergente=1 order by fchReg desc limit 1";

        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(    
            $this->idAviso,
            $this->fchReg,
            $this->titulo,
            $this->texto,
            $this->destacado,
            $this->emergente,
            $this->link,
            $this->estado,
            $this->idUsuario
            );
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Aviso obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Aviso";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();

        return $this->md_estado;
    }

    public function getbyNombre($nombre){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($nombre)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un nombre para buscar";
            return $this->md_estado = false;
        }

        $sql="select * from aviso where titulo like ?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('s', $nombre);    //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
            $this->idAviso,
            $this->fchReg,
            $this->titulo,
            $this->texto,
            $this->destacado,
            $this->emergente,
            $this->link,
            $this->estado,
            $this->idUsuario
            );
        if($stmt->fetch()){
            $this->md_estado=true;
            $this->md_mensaje="Aviso obtenido";
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Aviso";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

}

?>