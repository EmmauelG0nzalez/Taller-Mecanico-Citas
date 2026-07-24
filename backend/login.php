<?php

session_start();
require_once "conexion.php";

$correo = trim($_POST["correo"] ?? "");
$password = $_POST["password"] ?? "";

$stmt = $conn->prepare(
    "SELECT id, nombre, correo, password, rol
     FROM usuarios
     WHERE correo = ?
     LIMIT 1"
);

$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    exit("Correo o contraseña incorrectos.");
}

$usuario = $resultado->fetch_assoc();

if (!password_verify($password, $usuario["password"])) {
    exit("Correo o contraseña incorrectos.");
}

session_regenerate_id(true);

$_SESSION["id"] = $usuario["id"];
$_SESSION["nombre"] = $usuario["nombre"];
$_SESSION["rol"] = $usuario["rol"];

header("Location: ../frontend/inicio.php");
exit();
?>
