<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Solicitud no permitida.");
}

$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$password = $_POST["password"] ?? "";

if ($nombre === "" || $correo === "" || $password === "") {
    exit("Todos los campos son obligatorios.");
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    exit("El correo electrónico no es válido.");
}

if (strlen($password) < 6) {
    exit("La contraseña debe tener al menos 6 caracteres.");
}

/* Comprobar que el correo no exista */
$consulta = $conn->prepare(
    "SELECT id FROM usuarios WHERE correo = ? LIMIT 1"
);

$consulta->bind_param("s", $correo);
$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {
    exit("El correo ya está registrado.");
}

$consulta->close();

/* Cifrar contraseña */
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

/*
 * No enviamos la columna rol.
 * MySQL usará automáticamente el valor DEFAULT 'cliente'.
 */
$registro = $conn->prepare(
    "INSERT INTO usuarios (nombre, correo, password)
     VALUES (?, ?, ?)"
);

$registro->bind_param(
    "sss",
    $nombre,
    $correo,
    $passwordHash
);

if ($registro->execute()) {
    header("Location: ../frontend/login.html?registro=exitoso");
    exit();
}

echo "No se pudo registrar el usuario.";

$registro->close();
$conn->close();
?>
