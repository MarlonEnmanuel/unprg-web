<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/abstractController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Usuario.php';

class ctrlUsuario extends abstractController {

    protected function init($accion){
        switch ($accion) {
            case 'login': $this->login(); break;

            case 'logout': $this->logout(); break;

            case 'cambiarContra': $this->cambiarContra(); break;
            
            default: $this->responder(false, "Acción no soportada"); break;
        }
    }


    public function create (){
        $this->checkAccess('admin');

        $ipts = $this->getFilterInputs(array(
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

        $aux=new Usuario($mysqli);
        if($aux->getbyNombre($user->email)){
            $this->responder(false, "Ya existe un user con el email: ".$user->email);
        }

        if($user->set()){
            $this->responder(true, 'Usuario creado! los datos de acceso son:<br>Email: '.$user->email.'<br>Contraseña: '.$randPass.'<br>Sírvase notificar al usuario');
        }else{
            $this->responder(false, $user->md_mensaje, $user->md_detalle);
        }
    }


    public function update (){
        $Usuario=$this->checkAccess('admin');
        $ipts = $this->getFilterInputs(array(
            'id'        => array('type'=>'int', 'min'=>1),
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

        $usuario=new Usuario($mysqli, $ipts['id']);
        $aux=new Usuario($mysqli);

        if($usuario->get()==false){
            $this->responder(false,'El Usuario no existe');
        }

        if($aux->getbyNombre($ipts['email'])){
            if($aux->id!=$usuario->id){
                $this->responder(false,"Ya existe un usuario con este correo: ".$usuario->email);

            }
        }

        $usuario->email = $ipts['email'];
        
        $usuario->nombres = $ipts['nombres'];
        $usuario->apellidos = $ipts['apellidos'];
        $usuario->oficina = $ipts['oficina'];
        $usuario->estado = $ipts['estado'];
        $usuario->permisos = $ipts['permisos'];

        if($usuario->edit()==false){
            $this->responder(false,"No se pudo actualizar el usuario",$usuario->md_detalle);
        }

        $this->responder(true,"Usuario actualizado!","",$usuario->toArray());
    }


    public function delete (){
        $Usuario=$this->checkAccess('admin');

        $ipts = $this->getFilterInputs(array(
                    '_id' => array('type'=>'int', 'min'=>1)
                ));

        $mysqli=$this->getMysqli();

        $usuario = new Usuario($mysqli, $ipts['_id']);

        if($usuario->get() == false){
            $this->responder(false, 'El usuario no existe');
        }

        

        if($usuario->reset() == false) {
            $this->responder(false, "No se pudo resetear el usuario", $usuario->md_detalle);
        }

        $this->responder(true, "usuario reseteado!", '', array('status'=>'ok'));
    }


    public function read (){
        $Usuario=$this->checkAccess();
        $mysqli=$this->getMysqli();

        $user=new Usuario($mysqli);
        $user->id=$Usuario['id'];

        if($user->get()==false)
            $this->responder(false, 'Error al obtener Usuario', $user->md_detalle);

        $user->permisos = implode(', ', explode(',', $user->permisos));


        $campos=array('id','email','nombres','apellidos','oficina','fchReg','permisos', 'estado', 'reset');

        $User=$user->toArray($campos);
        $User['fchReg']=$user->fchReg->format("d/m/Y H:i");
        $this->responder(true, 'Usuario obtenido', '',$User );
        
    }


    public function readList (){
        $mysqli = $this->getMysqli();

        $_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
        $_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

        $aux = new Usuario($mysqli);

        $lista=$aux->search(true,$_limit,$_offset);

        if(empty($lista)){
            $this->responder(false, 'No hay usuarios para mostrar');
        }

        $usuarios = array();
        foreach ($lista as $key => $user) {
            $usuarios[$key] = $user->toArray();
        }

        $this->responder(true, 'usuarios obtenidos', '', $usuarios);
    }


    public function readAll(){
        $Usuario=$this->checkAccess('admin');
        $mysqli = $this->getMysqli();

        $_limit   = $this->getInputInt('_limit', array('min'=>1, 'required'=>false));
        $_offset  = $this->getInputInt('_offset', array('min'=>0, 'required'=>false));

        $aux = new Usuario($mysqli);

        $lista=$aux->search(false,$_limit,$_offset);
        

        if(empty($lista)){
            $this->responder(false, 'No hay usuarios para mostrar');
        }

        $usuarios = array();
        foreach ($lista as $key => $user) {
            if(strpos($user->permisos,'admin')===false){
                array_push($usuarios, $user);
            }
        }

        $this->responder(true, 'usuarios obtenidos', '', $usuarios);
    }


    protected function login(){
        $inputs = $this->getFilterInputs( array(
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

        $ipts = $this->getFilterInputs( array(
            'pass'      => array('type'=>'string'),
            'nuevoPass' => array('type'=>'string'),
            'nuevoPass2'=> array('type'=>'string'),
        ));

        if($Usuario['password']!=$ipts['pass']){
            $this->responder(false, 'Contraseña incorrecta');
        }

        if($ipts['nuevoPass']!=$ipts['nuevoPass2']){
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
        $this->responder(true, 'Contraseña cambiada');
    }

}

$ctrl = new ctrlUsuario(true);

?>
