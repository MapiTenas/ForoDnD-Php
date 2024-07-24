<?php
require_once '../Model/tema.php';

class TemaController {
    public function obtenerTemasPorCategoria($categoria_id) {
        return Tema::obtenerTemasPorCategoria($categoria_id);
    }
}
?>
