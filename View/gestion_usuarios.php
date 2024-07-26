<?php include '../Resources/session_start.php'; ?>
<?php include '../Model/CONNECT-DB.php'; ?>
<?php include '../Model/usuario.php';

$connection = getDbConnection();  // Obtén la conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foro D&D</title>
    <link rel="stylesheet" href="../Resources/styles.css">
</head>
<body>
<?php include '../Resources/header.php' ?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <h2>Listado de usuarios del foro</h2>

    <?php
    $usuario = new Usuario($connection);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_id'])) {
        $usuario->deleteUser($_POST['delete_user_id']);
    }
    $users = $usuario->getUsers();
    ?>

    <table>
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                        <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="btn-delete">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>




<?php endif; ?>

