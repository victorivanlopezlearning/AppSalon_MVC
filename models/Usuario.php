<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    // Atributos por cada columna tabla
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '0';
    }

    // Mensajes de validación para Crear Cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        };
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        };
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es obligatorio';
        };
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        };
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
            $passwordVacio = true;
        } else {
            $passwordVacio = false;
        };
        if( (strlen($this->password) < 6) && ($passwordVacio === false)) { // Valida longitud password
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        };

        return self::$alertas;
    }

    // Mensajes de validación para Login
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        };
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        };
        
        return self::$alertas;
    }

    // Mensajes de validación para Email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        };
        
        return self::$alertas;
    }

    // Mensajes de validación para Password
    public function validarPassword() {
        
        $passwordVacio = false;

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
            $passwordVacio = true;
        };
        if( (strlen($this->password) < 6) && ($passwordVacio === false)) { // Valida longitud password
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        };
        
        return self::$alertas;
    }
    
    // Validar si existe usuario en la BD
    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query); // Consultar la BD
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya está registrado';
        };

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        // Comprobar Contraseña
        $resultado = password_verify($password, $this->password);

        // Cmprobar Confirmado
        if(!$resultado || !$this->confirmado === '1') {
            self::$alertas['error'][] = 'El password es incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        };
    }
};