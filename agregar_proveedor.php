<?php
include 'conexion.php';

function limpiarEntrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$nombre = limpiarEntrada($_POST['nombre']);
$empresa = limpiarEntrada($_POST['empresa']);
$email = limpiarEntrada($_POST['email']);
$telefono = limpiarEntrada($_POST['telefono']);
$direccion = limpiarEntrada($_POST['direccion']);

$errores = array();

if (empty($nombre) || !preg_match("/^[A-Za-z\s]+$/", $nombre)) {
    $errores[] = "El nombre es obligatorio y solo puede contener letras y espacios.";
}

if (empty($empresa)) {
    $errores[] = "El nombre de la empresa es obligatorio.";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email es obligatorio y debe tener un formato válido.";
}

if (!empty($telefono) && !preg_match("/^\d{10}$/", $telefono)) {
    $errores[] = "El teléfono debe contener 10 dígitos.";
}

if (count($errores) == 0) {
    $sql = "INSERT INTO proveedores (nombre, empresa, email, telefono, direccion) VALUES ('$nombre', '$empresa', '$email', '$telefono', '$direccion')";
    if ($conn->query($sql) === TRUE) {
        echo "Proveedor agregado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    foreach ($errores as $error) {
        echo "<p>Error: $error</p>";
    }
}

$conn->close();
?>