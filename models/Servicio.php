<?php

namespace Model;

class Servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    // Atributos por cada columna tabla
    public $id;
    public $nombre;
    public $precio;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

     // Mensajes de validación para formulario de servicio
     public function validarServicio() {
        $passwordVacio = false;

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del Servicio es obligatorio';
        };
        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio del Servicio es obligatorio';
            $passwordVacio = true;
        };
        if((!is_numeric($this->precio)) && ($passwordVacio === false)) { // is_numeric() | comprueba que sea número el proprocionado
            self::$alertas['error'][] = 'El precio no tiene un formato valido';
        };
        
        return self::$alertas;
    }
}