<?php

session_start();

include("conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios
WHERE correo='$correo'
AND password='$password'";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    $usuario = $resultado->fetch_assoc();

    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];

    header("Location: ../frontend/inicio.html");

}

$conn->close();

?>