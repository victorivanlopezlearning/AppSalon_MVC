<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index(Router $router) {

        // Validar que el usuario esta autentificado
        session_start();
        isAuth();
        
        $router->render('cita/index', [
            'titulo' => 'Cita',
            'nombreUsuario' => $_SESSION["nombre"],
            'idUsuario' => $_SESSION['id']
        ]);
    }
}