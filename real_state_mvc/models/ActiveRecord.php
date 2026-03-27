<?php

namespace App;

class ActiveRecord {
    // Base de Datos de forma protegida (no de reescribe NUNCA)
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Propiedades de instancia
    public $id;
    public $imagen;

    // Errores/Validacion
    protected static $errores = [];

    // Definir la conexion a la BD
    public static function setDB($database) {
        self::$db = $database;
    }


    public function guardar() {
        if (!is_null($this->id)) {
            //Actualizar
            $this->actualizar();
        } else {
            // Crear un nuevo registro
            $this->crear();
        }
    }
    public function crear() {
        // Asignar el próximo ID disponible
        $this->id = self::obtenerProximoId();

        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .=  join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);

        if($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        $valores = []; //Va al objeto en memoria y une atributos con valores
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(',',$valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');
        }
    }

    // Eliminar un registro
    public function eliminar() {

        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        } 
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];

        foreach(static::$columnasDB as $columna) {
            // Incluir el id solo si ya está asignado (para creación con ID específico)
            if($columna === 'id' && !isset($this->id)) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarDatos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            //Solo se sanitizan los valores
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Elimina el archivo
    public function borrarImagen() {
        //Comprobar si existe el archivo
        $exist = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($exist) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validacion
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {

        static::$errores = [];
        return static::$errores;
    }

    public function setImagen($imagen) {
        //Elimina la imagen previa

        if(!is_null($this->id)) {
            $this->borrarImagen();
        }

        //Asigna el atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Lista todas los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;//Retorna un arreglo

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //Obtiene determinado numero de registros
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;//Retorna un arreglo

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca un resgistro por su ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);//Retorna el primer elemento de un arreglo
    }

    public static function consultarSQL($query){

        //1. Consultar la base de datos
            $resultado = self::$db->query($query);

        //2. Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObj($registro);
            }

        //3. Liberar la memoria
            $resultado->free();

        //4. Retornar los resultados
            return $array;
    }
    //Funcion: convierte de arreglo a objeto
    protected static function crearObj($registro) {
        $objeto = new static;

        //Crea un objeto en memoria con los arrays
        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
    /* FIN DE LISTA DE LAS PROPIEDADES */

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        //Rescribe cada atributo del objeto en memoria
        foreach($args as $key => $value) { //Key/value por que es un arr asociativo
            if(property_exists($this, $key ) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Obtiene el próximo ID disponible (reutiliza huecos y reinicia cuando esté vacío)
    public static function obtenerProximoId() {
        // Obtener todos los IDs existentes ordenados
        $query = "SELECT id FROM " . static::$tabla . " ORDER BY id ASC";
        $resultado = self::$db->query($query);
        
        $ids = [];
        while($fila = $resultado->fetch_assoc()) {
            $ids[] = $fila['id'];
        }
        
        // Si no hay IDs, empezar desde 1
        if(empty($ids)) {
            return 1;
        }
        
        // Buscar el primer hueco en la secuencia
        for($i = 1; ; $i++) {
            if(!in_array($i, $ids)) {
                return $i;
            }
        }
    }
}