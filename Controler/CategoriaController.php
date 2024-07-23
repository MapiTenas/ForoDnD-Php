<?php
require_once '../Model/categoria.php';

class CategoriaController {
    public function obtenerCategorias() {
        return Categoria::obtenerCategorias();
    }
}
?>
