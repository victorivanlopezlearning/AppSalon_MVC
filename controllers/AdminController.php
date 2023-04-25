<?php 

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {

    public static function index(Router $router) {
        // Validar que el usuario sea Administrador
        session_start();
        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha); // Se divide la fecha para posterior validarla

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])) { // checkdate() | valida que la fecha que se le proporcionó es una fecha valida
            header('Location: /404');
        };

        // Consultar la base de datos
        // Es recomendable utilizarce una clase query builder pero en este proyecto se realizará de manera "manual" la consulta
        $query = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $query .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ";
        $query .= " FROM citas ";
        $query .= " LEFT OUTER JOIN usuarios ";
        $query .= " ON usuarios.id = citas.usuarioId ";
        $query .= " LEFT OUTER JOIN citas_servicios ";
        $query .= " ON citas_servicios.citaId = citas.id ";
        $query .= " LEFT OUTER JOIN servicios ";
        $query .= " ON servicios.id = citas_servicios.servicioId ";
        $query .= " WHERE fecha =  '{$fecha}' ";

        $citas = AdminCita::SQL($query);

        $router->render('admin/index', [
            'titulo' => 'Administración',
            'nombreUsuario' => $_SESSION['nombre'],
            'fecha' => $fecha,
            'citas' => $citas
        ]);
    }
};