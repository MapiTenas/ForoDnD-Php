<?php
require_once '../Model/Comentario.php';

class ComentarioController {

    public function obtenerComentariosPorTemaId($tema_id) {
        return Comentario::obtenerComentariosPorTemaId($tema_id);
    }
}
?>
