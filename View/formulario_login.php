<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foro D&D</title>
    <link rel="stylesheet" href="../Resources/styles.css">
</head>

<body>
<?php include '../Resources/header.php' ?>
<br>
<h1>Iniciar sesión</h1>
<h2>Estás a un clic de poder empezar a postear tus propios temas. </h2>
<h3>Recuerda mantener tu contraseña secreta</h3>
<br>
<div class="form-container">
    <form action="../login.php" method="post">
        <div class="form-group">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="submit">Iniciar sesión</button>
        </div>
    </form>
</div>

<br>
<br>

<?php include '../Resources/footer.php' ?>
</body>
</html>