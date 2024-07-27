<?php
session_start();
include 'php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['user'];
    $password = $_POST['password']; // En un caso real, deberías hashear y verificar la contraseña

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE user = :user");
    $consulta->bindParam(':user', $usuario, PDO::PARAM_STR);
    $consulta->execute();
    $usuarioData = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuarioData) {
        $_SESSION['user'] = $usuarioData['user'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="user">Usuario</label>
            <input type="text" id="user" name="user" required>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
