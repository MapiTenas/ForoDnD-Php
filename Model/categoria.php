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

    public function guardarNuevaCategoria() {
        $conexion = getDbConnection();
        $query = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $this->nombre, $this->descripcion);
        $resultado = $stmt->execute();
        $stmt->close();
        $conexion->close();
        return $resultado;
    }

    public function eliminarCategoria() {
        $conexion = getDbConnection();
        $conexion->begin_transaction();

        try {
            // Primero, obtenemos todos los temas asociados con la categoría
            $queryTemas = "SELECT id FROM temas WHERE categoria_id = ?";
            $stmtTemas = $conexion->prepare($queryTemas);
            $stmtTemas->bind_param("i", $this->id);
            $stmtTemas->execute();
            $resultTemas = $stmtTemas->get_result();
            $temasIds = [];

            while ($row = $resultTemas->fetch_assoc()) {
                $temasIds[] = $row['id'];
            }
            $stmtTemas->close();

            // Ahora eliminamos los comentarios asociados a esos temas
            if (!empty($temasIds)) {
                $queryComentarios = "DELETE FROM comentarios WHERE tema_id IN (" . implode(',', $temasIds) . ")";
                $stmtComentarios = $conexion->prepare($queryComentarios);
                $stmtComentarios->execute();
                $stmtComentarios->close();
            }

            // Luego eliminamos los temas asociados a la categoría
            if (!empty($temasIds)) {
                $queryEliminarTemas = "DELETE FROM temas WHERE categoria_id = ?";
                $stmtEliminarTemas = $conexion->prepare($queryEliminarTemas);
                $stmtEliminarTemas->bind_param("i", $this->id);
                $stmtEliminarTemas->execute();
                $stmtEliminarTemas->close();
            }

            // Finalmente, eliminamos la categoría
            $queryEliminarCategoria = "DELETE FROM categorias WHERE id = ?";
            $stmtEliminarCategoria = $conexion->prepare($queryEliminarCategoria);
            $stmtEliminarCategoria->bind_param("i", $this->id);
            $resultado = $stmtEliminarCategoria->execute();
            $stmtEliminarCategoria->close();

            if (!$resultado) {
                throw new Exception("Error al eliminar la categoría.");
            }

            $conexion->commit();
            $conexion->close();
            return true;
        } catch (Exception $e) {
            $conexion->rollback();
            $conexion->close();
            error_log($e->getMessage());
            return false;
        }
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