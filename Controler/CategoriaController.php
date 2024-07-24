<?php
require_once '../Model/categoria.php';

class CategoriaController {
    public function obtenerCategorias() {
        return Categoria::obtenerCategorias();
    }

    public function crearCategoria($nombre, $descripcion) {
        $categoria = new Categoria(null, $nombre, $descripcion);
        return $categoria->guardarNuevaCategoria();
    }

    public function eliminarCategoria($id) {
        $categoria = new Categoria($id, null, null);
        return $categoria->eliminarCategoria();
    }

    public function obtenerCategoriaPorId($id) {
        $conexion = getDbConnection();
        $query = "SELECT * FROM categorias WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $categoria = null;
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $categoria = new Categoria($fila['id'], $fila['nombre'], $fila['descripcion']);
        }

        $stmt->close();
        $conexion->close();

        return $categoria;
    }





}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (isset($_POST['nombre']) && isset($_POST['descripcion'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $controller = new CategoriaController();
        $resultado = $controller->crearCategoria($nombre, $descripcion);

        if ($resultado) {
            header("Location: ../View/index.php");
            exit();
        } else {
            echo "Error al crear la categoría.";
        }
    }
}



?>
