<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';

class ctrlUsuario extends abstractController {

    protected function init($accion){
        switch ($accion) {
            case 'login': $this->login(); break;

            case 'logout': $this->logout(); break;
            
            default: $this->responder(false, "Acción no soportada"); break;
        }
    }

    public function create ($model){
        $this->checkAccess('admin');

        $ipts = $this->getFilterInputs('post', array(
            'email'     => array('type'=>'email'),
            'nombres'   => array('type'=>'string', 'min'=>4, 'max'=>45),
            'apellidos' => array('type'=>'string', 'min'=>4, 'max'=>45),
            'oficina'   => array('type'=>'string', 'min'=>4, 'max'=>45),
            'estado'    => array('type'=>'boolean'),
            'p-aviso'   => array('type'=>'boolean'),
            'p-noticia' => array('type'=>'boolean'),
            'p-agenda'  => array('type'=>'boolean'),
            'p-imagen'  => array('type'=>'boolean'),
            'p-documento'  => array('type'=>'boolean'),
            'p-enlace'  => array('type'=>'boolean'),
            'p-portada'  => array('type'=>'boolean'),
            'p-pagina'  => array('type'=>'boolean')

        ));

        $ipts['permisos'] = array();
        if($ipts['p-aviso']) array_push($ipts['permisos'], 'aviso');
        if($ipts['p-noticia']) array_push($ipts['permisos'], 'noticia');
        if($ipts['p-agenda']) array_push($ipts['permisos'], 'agenda');
        if($ipts['p-imagen']) array_push($ipts['permisos'], 'imagen');
        if($ipts['p-documento']) array_push($ipts['permisos'], 'documento');
        if($ipts['p-enlace']) array_push($ipts['permisos'], 'enlace');
        if($ipts['p-portada']) array_push($ipts['permisos'], 'portada');
        if($ipts['p-pagina']) array_push($ipts['permisos'], 'pagina');
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

    public function update ($model){

    }

    public function delete ($_id){

    }

    public function read ($_id){
        
        $Usuario=$this->checkAccess();
        $mysqli=$this->getMysqli();

        $user=new Usuario($mysqli);
        $user->id=$Usuario['id'];
        if($user->get()==false)
            $this->responder(false, 'Error al obtener Usuario', $user->md_detalle);


        $campos=array('id','email','nombres','apellidos','oficina','fchReg','permisos');

        $User=$user->toArray($campos);
        $User['fchReg']=$user->fchReg->format("d/m/Y H:i");
        $this->responder(true, 'Usuario obtenido', '',$User );
        
    }

    public function readList ($limit, $offset){

    }

    protected function login(){
        $inputs = $this->getFilterInputs('post', array(
            'email' => array('type'=>'email'),
            'pass'  => array('type'=>'string', 'min'=>'40', 'max'=>'40'),
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
        $this->responder(true, 'Bienvenido', 'redirect', '/gestion/miUsuario.php');
    }

    public function logout(){
        session_start();
        session_destroy();
        $mensaje = "Hasta luego";
        header('Location: /gestion?msj='.$mensaje);
        exit();
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
            'pass'      => array('type'=>'string', 'min'=>40, 'max'=>40),
            'nuevoPass' => array('type'=>'string', 'min'=>40, 'max'=>40),
            'nuevoPass2'=> array('type'=>'string', 'min'=>40, 'max'=>40),
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
