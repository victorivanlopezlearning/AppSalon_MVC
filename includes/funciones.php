<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo) : bool {
    if($actual !== $proximo) {
        return true;
    };
    return false;
};

// Revisa si el usuario está autentificado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    };
};

function isAdmin() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /cita');
    };
};

// Muestra los mensajes
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Servicio Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Servicio Editado Correctamente';
            break;
        case 3:
            $mensaje = 'Servicio Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    };
    return $mensaje;
};