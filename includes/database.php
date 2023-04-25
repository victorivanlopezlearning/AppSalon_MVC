<?php
date_default_timezone_set("America/Mexico_City"); // Establecer zona horaria local para el servidor
$db = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_DATABASE"]);
$db->set_charset("utf8"); // Soporte para caracteres especiales


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
