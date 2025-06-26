<?php
session_start();
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['tipo_usuario'], ['Administrador', 'Donante'])) {
    header("Location: login.php");
    exit();
}
include "conexion.php";
$stmt = $conn->prepare("SELECT d.*, u.nombre AS nombre_usuario, n.descripcion AS desc_necesidad 
    FROM donaciones d 
    JOIN usuarios u ON d.id_usuario = u.id_usuario 
    JOIN necesidades n ON d.id_necesidad = n.id_necesidad");
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYNI - Gestionar Donaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00695c;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">AYNI</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php">Volver</a>
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <h2 class="text-center mb-4">Donaciones Registradas</h2>
        <a href="agregar_donacion.php" class="btn btn-primary mb-3">Agregar Donación</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Necesidad</th>
                    <th>Cantidad</th>
                    <th>Comentario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_donacion']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['desc_necesidad']); ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        <td><?php echo htmlspecialchars($row['comentario']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado']); ?></td>
                        <td>
                            <a href="editar_donacion.php?id=<?php echo $row['id_donacion']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar_donacion.php?id=<?php echo $row['id_donacion']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>