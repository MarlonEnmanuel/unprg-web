<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/16/backend/config.php';
require_once config::getRequirePath('backend/models/abstractModel.php');

/**
 * Modelo usuario
 *
 * Esta clase representa el modelo de la tabla usuario de la BD
 *
 * @author Marlon Enmanuel Montalvo Flores
 */
class Usuario extends abstractModel{

	public $email;
	public $password;
	public $nombres;
	public $apellidos;
	public $oficina;
	public $fchReg;
	public $permisos;
	public $estado;
	public $reset;

	public function __construct(&$mysqli, $id=null){
		parent::__construct($mysqli, $id);
	}

	public function get(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

		if(!isset($this->id)){					//debe tener id para buscar
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}

		$sql = "select * from usuario where idUsuario=?";
		$stmt = $this->mysqli->stmt_init();	//se inicia la consulta preparada
		$stmt->prepare($sql);				//se arma la consulta preparada
		$stmt->bind_param('i', $this->id);	//se vinculan los parámetros
		$stmt->execute();					//se ejecuta la consulta
		$stmt->bind_result( 				//se vinculan las variables que obtendrán los resultados
			$this->id,
			$this->email,
			$this->password,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->fchReg,
			$this->permisos,
			$this->estado,
			$this->reset
			);
		if($stmt->fetch()){
			$this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;				//estado del procedimiento: correcto
            $this->md_mensaje = "Usuario obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;				//estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener usuario";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
            
        }
        $stmt->close();
        return $this->md_estado;					//devuelve el estado del procedimiento
	}

	public function getEmail($email){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

		$sql = "select * from usuario where email=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result(
			$this->id,
			$this->email,
			$this->password,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->fchReg,
			$this->permisos,
			$this->estado,
			$this->reset
			);
		if($stmt->fetch()){
			$this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;
            $this->md_mensaje = "Usuario obtenido";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al obtener usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

    public function set(){
    	if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "El usuario ya tiene id";
    		return $this->md_estado = false;
    	}

    	$sql = "INSERT INTO usuario (email, password, nombres, apellidos, oficina, permisos, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    	$stmt = $this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('ssssssi',
    		$this->email,
    		$this->password,
    		$this->nombres,
    		$this->apellidos,
    		$this->oficina,
    		$this->permisos,
    		intval($this->estado)
    		);
    	if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Usuario insertado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function edit(){
    	if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(!isset($this->id)){	//debe tener id para poder editar
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}

    	$sql = "UPDATE usuario SET 
					email=?, 
					password=?, 
					nombres=?, 
					apellidos=?, 
					oficina=?, 
					permisos=?, 
					estado=?, 
					reset=? 
				WHERE idUsuario=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('ssssssii',
			$this->email,
			$this->password,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->permisos,
			intval($this->estado),	//combertir booleano a 0 ó 1 para insertar en la BD
			intval($this->reset)	//combertir booleano a 0 ó 1 para insertar en la BD
			);
		if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Usuario actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function delete(){

    }

}

?>