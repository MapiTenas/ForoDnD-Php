<?php
require_once 'CONNECT-DB.php';

class categoria {
    private $id;
    private $nombre;
    private $descripcion;

    public function __construct($id, $nombre, $descripcion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public static function obtenerCategorias() {
        $conexion = getDbConnection();
        $query = "SELECT * FROM categorias";
        $resultado = $conexion->query($query);

        $categorias = [];
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $categorias[] = new Categoria($fila['id'], $fila['nombre'], $fila['descripcion']);
            }
        }
        $conexion->close();
        return $categorias;
    }



    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getNombre()
    {
        return $this->nombre;
    }


    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }


    public function getDescripcion()
    {
        return $this->descripcion;
    }


    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }


}