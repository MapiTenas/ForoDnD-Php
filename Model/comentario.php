<?php
require_once 'CONNECT-DB.php';

class Comentario {
    private $id;
    private $contenido;
    private $tema_id;
    private $usuario_id;
    private $usuario_username;
    private $created_at;

    public function __construct($id, $contenido, $tema_id, $usuario_id, $usuario_username, $created_at) {
        $this->id = $id;
        $this->contenido = $contenido;
        $this->tema_id = $tema_id;
        $this->usuario_id = $usuario_id;
        $this->usuario_username = $usuario_username;
        $this->created_at = $created_at;
    }

    public static function obtenerComentariosPorTemaId($tema_id) {
        $conexion = getDbConnection();
        $query = "SELECT c.id, c.contenido, c.tema_id, c.usuario_id, u.username AS usuario_username, c.created_at
                  FROM comentarios c
                  JOIN usuarios u ON c.usuario_id = u.id
                  WHERE c.tema_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $tema_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $comentarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $comentarios[] = new Comentario(
                $fila['id'],
                $fila['contenido'],
                $fila['tema_id'],
                $fila['usuario_id'],
                $fila['usuario_username'], // Asignamos el valor obtenido del JOIN
                $fila['created_at']
            );
        }
        $stmt->close();
        $conexion->close();
        return $comentarios;
    }

    public static function crearComentario($contenido, $tema_id, $usuario_id) {
        $conexion = getDbConnection();
        $query = "INSERT INTO comentarios (contenido, tema_id, usuario_id, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sii", $contenido, $tema_id, $usuario_id);
        $stmt->execute();
        $stmt->close();
        $conexion->close();
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function setContenido($contenido): void {
        $this->contenido = $contenido;
    }

    public function getTemaId() {
        return $this->tema_id;
    }

    public function setTemaId($tema_id): void {
        $this->tema_id = $tema_id;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    public function getUsuarioUsername() {
        return $this->usuario_username;
    }

    public function setUsuarioUsername($usuario_username): void {
        $this->usuario_username = $usuario_username;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void {
        $this->created_at = $created_at;
    }
}
?>
