<?php

include("conexion.php");

$sql = "SELECT * FROM citas";

$resultado = $conn->query($sql);

echo "<h2>Listado de Citas</h2>";

echo "<table border='1'>";
echo "<tr>
<th>ID</th>
<th>Cliente</th>
<th>Telefono</th>
<th>Vehiculo</th>
<th>Servicio</th>
<th>Fecha</th>
<th>Hora</th>
<th>Estado</th>
</tr>";

while($fila = $resultado->fetch_assoc()){

echo "<tr>
<td>".$fila['id']."</td>
<td>".$fila['nombre_cliente']."</td>
<td>".$fila['telefono']."</td>
<td>".$fila['vehiculo']."</td>
<td>".$fila['servicio']."</td>
<td>".$fila['fecha']."</td>
<td>".$fila['hora']."</td>
<td>".$fila['estado']."</td>
</tr>";

}

echo "</table>";

$conn->close();

?>