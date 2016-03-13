<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/16/backend/config.php';
require_once config::getRequirePath('backend/controllers/abstractController.php');
require_once config::getRequirePath('backend/models/Usuario.php');

class ctrlUsuario extends abstractController {

    protected function init($accion){

        if($accion == 'login'){         //acción del controlador
            $this->login();

        }elseif($accion == 'logout'){   //acción del controlador
            $this->logout();    

        }elseif($accion == 'nuevoUsuario'){         //acción del controlador
            $this->nuevoUsuario();

        }elseif($accion == ''){         //acción del controlador


        }else{                          //responde cuando la acción no corresponde a ningun controlador
            $this->responder(false, "Acción no soportada");
        }
    }

    protected function login(){
        $inputs = $this->getFilterInputs('post', array(
            'email' => 'email',
            'pass' => 'string'
        ));

        $mysqli = $this->getMysqli();

        $user = new Usuario($mysqli);
        $user->getEmail($inputs['email']);

        if($user->md_estado == false) $this->responder(false, "Usuario incorrecto");
        if($user->password != $inputs['pass']) $this->responder(false, "Contraseña incorrecta");

        if(!$user->estado) $this->responder(false, "Usuario bloqueado, contacte con el administrador");

        session_start();
        $user->permisos = explode(',', $user->permisos);
        $_SESSION['Usuario'] = $user->toArray();
        $this->responder(true, 'Bienvenido', 'redirect', config::getPath(false, '/gestion/panel.php'));
    }

    public function logout(){
        session_start();
        session_destroy();
        $mensaje = "Hasta luego";
        header('Location: '.config::getPath(false ,'/admin').'?msj='.$mensaje);
        exit();
    }

    protected function nuevoUsuario(){
        $this->checkAccess('admin');

        $ipts = $this->getFilterInputs('post', array(
            'email' => 'email',
            'nombres' => array('string', 4, 45),
            'apellidos' => array('string', 4, 45),
            'oficina' => array('string', 4, 45),
            'estado' => 'boolean',
            'p-aviso' => 'boolean',
            'p-noticia' => 'boolean',
            'p-evento' => 'boolean'
        ));

        $ipts['permisos'] = array();
        if($ipts['p-aviso']) array_push($ipts['permisos'], 'aviso');
        if($ipts['p-noticia']) array_push($ipts['permisos'], 'noticia');
        if($ipts['p-evento']) array_push($ipts['permisos'], 'evento');
        if( empty($ipts['permisos']) ){
            $this->responder(false, 'Debe elegir al menos un acceso');
        }
        $ipts['permisos'] = implode(',', $ipts['permisos']);

        $mysqli = $this->getMysqli();

        $aux = new Usuario($mysqli);
        if( $aux->getEmail($ipts['email']) ){
            $this->responder(false, 'El email '.$ipts['email'].' ya está en uso');
        }

        $randPass = $this->getRandomPass(8);
        $user = new Usuario($mysqli);
        $user->email = $ipts['email'];
        $user->password = sha1($randPass);
        $user->nombres = $ipts['nombres'];
        $user->apellidos = $ipts['apellidos'];
        $user->oficina = $ipts['oficina'];
        $user->estado = $ipts['estado'];
        $user->permisos = $ipts['permisos'];

        if($user->set()){
            $this->responder(true, 'Usuario creado! los datos de acceso son:<br>Email: '.$user->email.'<br>Contraseña: '.$randPass.'<br>Sírvase notificar al usuario');
        }else{
            $this->responder(false, $user->md_mensaje, $user->md_detalle);
        }
    }

    private function getRandomPass($length){
        $pass = '';
        for ($i=0; $i < $length; $i++) { 
            $pass .= chr(rand(97,122));
        }
        return $pass;
    }

    protected function cambiarContra(){
        $Usuario = $this->checkAccess();

        $ipts = $this->getFilterInputs('post', array(
            'pass' => array('string', 40, 40),
            'nuevoPass' => array('string', 40, 40),
            'nuevoPass2' => array('string', 40, 40),
        ));

        if($Usuario['password']!=$ipts['pass']){
            $this->responder(false, 'Contraseña incorrecta');
        }

        if($ipts['nuevoPass']!=$ipts['nuevoPass']){
            $this->responder(false, 'Las contraseñas no coinciden');
        }

        $mysqli = $this->getMysqli();

        $user = new Usuario($mysqli, $Usuario['id']);
        $user->get();
        $user->password = $ipts['nuevoPass'];

        if(!$user->edit()){
            $this->responder(false, 'Error al guardar cambios', $user->md_detalle);
        }

        $_SESSION['Usuario'] = $user->toArray();
        $this->responder(true, 'Cambios guardados');
    }

}

$ctrl = new ctrlUsuario(true);

?>
