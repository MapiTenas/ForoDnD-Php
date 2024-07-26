<?php
require_once 'CONNECT-DB.php';

class tema {
    private $id;
    private $categoria_id;
    private $titulo;
    private $contenido;
    private $usuario_id;
    private $usuario_username;
    private $created_at;

    public function __construct($id, $categoria_id, $titulo, $contenido, $usuario_id, $usuario_username, $created_at) {
        $this->id = $id;
        $this->categoria_id = $categoria_id;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->usuario_id = $usuario_id;
        $this->usuario_username = $usuario_username;
        $this->created_at = $created_at;
    }

    public static function obtenerTemasPorCategoria($categoria_id) {
        $conexion = getDbConnection();
        $query = "SELECT t.id, t.categoria_id, t.titulo, t.contenido, t.usuario_id, u.username AS usuario_username, t.created_at
                  FROM temas t
                  JOIN usuarios u ON t.usuario_id = u.id
                  WHERE t.categoria_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $temas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $temas[] = new Tema(
                $fila['id'],
                $fila['categoria_id'],
                $fila['titulo'],
                $fila['contenido'],
                $fila['usuario_id'],
                $fila['usuario_username'],
                $fila['created_at']
            );
        }
        $stmt->close();
        $conexion->close();
        return $temas;
    }

    public static function crearTema($categoria_id, $titulo, $contenido, $usuario_id) {
        $conexion = getDbConnection();
        $query = "INSERT INTO temas (categoria_id, titulo, contenido, usuario_id, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("issi", $categoria_id, $titulo, $contenido, $usuario_id);

        $resultado = $stmt->execute();

        if ($resultado) {
            $id = $stmt->insert_id;
        } else {
            $id = null;
        }

        $stmt->close();
        $conexion->close();
        return $id;
    }

    public static function obtenerTemaPorId($id) {
        $conexion = getDbConnection();
        $query = "SELECT t.id, t.categoria_id, t.titulo, t.contenido, t.usuario_id, u.username AS usuario_username, t.created_at
              FROM temas t
              JOIN usuarios u ON t.usuario_id = u.id
              WHERE t.id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            $tema = new Tema(
                $fila['id'],
                $fila['categoria_id'],
                $fila['titulo'],
                $fila['contenido'],
                $fila['usuario_id'],
                $fila['usuario_username'],
                $fila['created_at']
            );
        } else {
            $tema = null;
        }

        $stmt->close();
        $conexion->close();
        return $tema;
    }

    public static function eliminarTema($id) {
        $conexion = getDbConnection();
        $conexion->begin_transaction();

        try {
            // Primero, eliminamos todos los comentarios asociados al tema
            $queryComentarios = "DELETE FROM comentarios WHERE tema_id = ?";
            $stmtComentarios = $conexion->prepare($queryComentarios);
            $stmtComentarios->bind_param("i", $id);
            $stmtComentarios->execute();
            $stmtComentarios->close();

            // Ahora eliminamos el tema
            $queryTema = "DELETE FROM temas WHERE id = ?";
            $stmtTema = $conexion->prepare($queryTema);
            $stmtTema->bind_param("i", $id);
            $resultado = $stmtTema->execute();
            $stmtTema->close();

            if (!$resultado) {
                throw new Exception("Error al eliminar el tema.");
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
    public function getCategoriaId()
    {
        return $this->categoria_id;
    }
    public function setCategoriaId($categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }
    public function getContenido()
    {
        return $this->contenido;
    }

    public function setContenido($contenido): void
    {
        $this->contenido = $contenido;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getUsuarioUsername() {
        return $this->usuario_username;
    }

    public function setUsuarioUsername($usuario_username): void {
        $this->usuario_username = $usuario_username;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }
}
?>
