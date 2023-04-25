<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;


class LoginController {

    public static function login(Router $router) {

        $alertas = [];
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth->sincronizar($_POST); // Sincronizar campos del formulario en el objeto instanciado
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if(!is_null($usuario)) {
                    // Validar si el usuario ya está confirmado y tiene correcta la contraseña
                    if($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        };
                    };
                } else {
                    Usuario::setAlerta('error', 'El usuario no está registrado');
                };
            };
        };

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'titulo' => 'Login',
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout() {
          // Acceder a sesión actual
          session_start();
          $_SESSION = []; // Eliminar sesión
          header('Location: /');
    }

    public static function crearCuenta(Router $router) {
        
        $usuario = new Usuario;

        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST); // Sincroniza la información del formulario en el objeto de la instancia
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que se pasó la validación
            if(empty($alertas)) {
                // Verificar que el usuario no esté registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // REGISTRAR USUARIO
                    // Hashear Password
                    $usuario->hashPassword();
                    // Generar un token único
                    $usuario->crearToken();
                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token); // Instanciando la clase de Email
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header('Location: /mensaje');
                    };
                   
                };
            };
        };
        
        $router->render('auth/crear-cuenta', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        
        $router->render('auth/mensaje', [
            'titulo' => 'Mensaje'
        ]);
    }

    public static function confirmarCuenta(Router $router) {
        
        $alertas = [];
        $token = !empty($_GET) ? s($_GET['token']) : ''; // Validar que la URL tenga token

        if(empty($token)) { // Valida que el token no venga vacia en la URL
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            $usuario = Usuario::where('token', $token);

            if(is_null($usuario)) {
                // Mostrar mensaje de error
                Usuario::setAlerta('error', 'Token no valido'); // Guardar alerta en memoria
            } else {
                // Modificar usuario a confirmado
                $usuario->confirmado = '1';
                $usuario->token = null;
                $usuario->guardar(); // Actualizar modificaciones en BD
                Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
            };
        };

        $alertas = Usuario::getAlertas(); // Recuperar alertas de memoria
        
        $router->render('auth/confirmar-cuenta', [
            'titulo' => 'Confirmar',
            'alertas' => $alertas
        ]);
    }

    public static function olvidePassword(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                // Validar que el email esta registrado
                $usuario = Usuario::where('email', $auth->email);
                
                if(!is_null($usuario) && $usuario->confirmado === '1') {
                    // Generar nuevo token
                    $usuario->crearToken();
                    // Guardar token en la base de datos
                    $usuario->guardar();
                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarRestablecer();
                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email para restablecer contraseña');
                } else {
                    Usuario::setAlerta('error', 'El email no existe o no está confirmado');
                };
            };
        };

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide-password', [
            'titulo' => 'Recuperar Contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function recuperarPassword(Router $router) {
       
        $alertas = [];
        $mostrarFormulario = true;
        
        // VALIDACIÓN TOKEN EN LA URL
        $token = !empty($_GET) ? s($_GET['token']) : '';

        if(empty($token)) { // Valida que el token no venga vacia en la URL
            Usuario::setAlerta('error', 'Token no valido');
            $mostrarFormulario = false;
        } else {
            // Validar Token
            $usuario = Usuario::where('token', $token);

            if(is_null($usuario)) {
                Usuario::setAlerta('error', 'Token no valido');
                $mostrarFormulario = false;
            };
        };

        // VALIDACIÓN Y GUARDADO DE CONTRASEÑA
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Guardar información del formualrio en memoria
            $password = new Usuario($_POST);
            // Validar campos
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                // Eliminamos password actual del usuario
                $usuario->password = null;
                // Establecer nueva contraseña
                $usuario->password = $password->password;
                // Hashear nueva contraseña
                $usuario->hashPassword();
                // Eliminar Token del usuario
                $usuario->token = null;
                // Guardar en base de datos contraseña nueva
                $resultado = $usuario->guardar();
                // Redireccionar usuario a Login
                if($resultado) {
                    header('Location: /');
                };
            };
        };

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'titulo' => 'Crear Contraseña',
            'alertas' => $alertas,
            'mostrarFormulario' => $mostrarFormulario
        ]);
    }
};