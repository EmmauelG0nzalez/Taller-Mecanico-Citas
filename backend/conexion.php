<?php

$host = getenv("DB_HOST") ?: "sql305.infinityfree.com";
$usuario = getenv("DB_USER") ?: "if0_42373159";
$contrasena = getenv("DB_PASSWORD") ?: "tbFFmCvm1qF";
$base_datos = getenv("DB_NAME") ?: "if0_42373159_taller_mecanico";

$conn = new mysqli(
    $host,
    $usuario,
    $contrasena,
    $base_datos
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
