<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all(); // Extraer todos los registros de la tabla

        echo json_encode($servicios); // json_encode() es una función de PHP que crea un JSON. En este caso con el resultado de la consulta de los servicios
    }

    public static function guardar() {

        // Tomando los valores que vienen de JavaScript
        $cita = new Cita($_POST); // El servidor va leer las solicitudes POST que se envien desde JavaScrip y lo va agregar al objeto del modelo Cita

        // Guardando en la base de datos la Cita y retornando su ID desde Active Record
        $resultado = $cita->guardar();

        // Guarda la cita y sus servicios relacionados
        $id = $resultado['id'];
        // Separar los servicios. explode() separa los resultados de un strign y los convierte en un arreglo
        $idServicios = explode(',', $_POST['servicios']); // el primero argumento de explode() indica el separador y el POST son los ids de los servicios que se envió desde JavaScript

        // Construir el arreglo que se enviará para la tabla citas_servicios
        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $CitaServicio = new CitaServicio($args);
            $CitaServicio->guardar();
        };

        // Envía respuesta del resultado
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener id
            $id = $_POST['id'];
            // Comprobar que solo sea un número el de ID
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if($id) {
                 // Buscar la cita por su id
                $cita = Cita::find($id);
                // Comprobar que se obtuvieron resultados
                if(!is_null($cita)) {
                    // Eliminar la cita
                    $cita->eliminar();
                };
            };
            // Redireccionar a la página donde se realizó el POST
            header('Location:' . $_SERVER['HTTP_REFERER']);
        };
    }
};