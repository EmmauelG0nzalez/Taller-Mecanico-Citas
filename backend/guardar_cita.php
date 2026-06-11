<?php

include("conexion.php");

$nombre = $_POST['nombre_cliente'];
$telefono = $_POST['telefono'];
$vehiculo = $_POST['vehiculo'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

$sql = "INSERT INTO citas
(nombre_cliente, telefono, vehiculo, servicio, fecha, hora)
VALUES
('$nombre','$telefono','$vehiculo','$servicio','$fecha','$hora')";

if($conn->query($sql) === TRUE){

    echo "Cita registrada correctamente";

}else{

    echo "Error: " . $conn->error;

}

$conn->close();

?>