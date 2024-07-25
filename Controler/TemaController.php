<?php
require_once '../Model/tema.php';

class TemaController {
    public function obtenerTemasPorCategoria($categoria_id) {
        return Tema::obtenerTemasPorCategoria($categoria_id);
    }

    public function crearTema($categoria_id, $titulo, $contenido, $usuario_id) {
        return Tema::crearTema($categoria_id, $titulo, $contenido, $usuario_id);
    }

}
?>
