<?php 

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // En el método createImmutable() se indica la ruta de nuestro archivo .env, en este caso esta en la misma raiz de este archivo por eso se le pone __DIR__
$dotenv->safeLoad(); // Hace que si el archivo .env no existe no marque errores nuestra aplicación

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);