<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
        session_start();
        isAdmin();

        // Utilización de la super global Get para extraer valores de la URL
        $resultado = $_GET['resultado'] ?? null;

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'titulo' => 'Servicios',
            'nombreUsuario' => $_SESSION['nombre'],
            'resultado' => $resultado,
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) {
        session_start();
        isAdmin();

        $servicio = new Servicio;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validarServicio();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios?resultado=1');
            };
        };

        $router->render('servicios/crear', [
            'titulo' => 'Nuevo Servicio',
            'nombreUsuario' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {
        session_start();
        isAdmin();

        // Obtener id de la URL
        $id = !empty($_GET) ? s($_GET['id']) : '';
        if(empty($id)) {
            header('Location: /servicios');
        };
        // Comprobar que solo sea un número el de ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id) {
            $servicio = Servicio::find($id);
            if(is_null($servicio)) {
                header('Location: /servicios');
            };
        };

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validarServicio();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios?resultado=2');
            };
        };

        $router->render('servicios/actualizar', [
            'titulo' => 'Actualizar Servicio',
            'nombreUsuario' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar() {
        session_start();
        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener id del elemento a eliminar
            $id = $_POST["id"];
             // Comprobar que solo sea un número el de ID
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                // Buscar el Servicio por su id
                $servicio = Servicio::find($id);
                // Comprobar que se obtuvieron resultados
                if(!is_null($servicio)) {
                    // Eliminar la servicio
                    $servicio->eliminar();
                    header('Location: /servicios?resultado=3');
                };
           };
        };
    }
};