<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    exit();
}

include('../backend/conexion.php');

$usuarioId = intval($_SESSION['id']);
$sql = "SELECT * FROM citas WHERE id_usuario = $usuarioId ORDER BY fecha ASC, hora ASC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas - Taller Mecánico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="inicio.html">Taller Mecánico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="inicio.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="citas.html">Agendar Cita</a></li>
                    <li class="nav-item"><a class="nav-link active" href="mis_citas.php">Mis Citas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1">Mis Citas</h1>
                <p class="text-muted mb-0">Revisa y administra tus citas agendadas.</p>
            </div>
            <a href="citas.html" class="btn btn-outline-primary">Agendar nueva cita</a>
        </div>

        <?php if (isset($_GET['guardado'])): ?>
            <div class="alert alert-success">✔ Tu cita se ha agendado correctamente.</div>
        <?php endif; ?>
        <?php if (isset($_GET['cancelado'])): ?>
            <div class="alert alert-success">✔ Tu cita se ha cancelado correctamente.</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">✗ Ocurrió un error. Intenta de nuevo.</div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($cita = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cita['servicio']) ?></td>
                                    <td><?= htmlspecialchars($cita['fecha']) ?></td>
                                    <td><?= htmlspecialchars($cita['hora']) ?></td>
                                    <td><?= htmlspecialchars(ucfirst($cita['estado'])) ?></td>
                                    <td class="text-end">
                                        <?php if ($cita['estado'] !== 'cancelado'): ?>
                                            <a href="../backend/cancelar_cita.php?id=<?= intval($cita['id']) ?>" class="btn btn-sm btn-outline-danger">Cancelar</a>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Cancelada</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h2 class="h5 text-muted">No tienes citas agendadas aún.</h2>
                    <p class="text-muted">Agrega una nueva cita desde el formulario para verla aquí.</p>
                    <a href="citas.html" class="btn btn-primary mt-3">Agendar cita</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

