<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$tipo_usuario = $_SESSION['usuario']['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYNI - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00695c;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">AYNI</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <h1 class="text-center mb-4">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($tipo_usuario); ?>)</h1>
        <div class="text-center">
            <?php if ($tipo_usuario == 'Administrador'): ?>
                <a href="usuarios.php" class="btn btn-primary m-2">Gestionar Usuarios</a>
            <?php endif; ?>
            <?php if ($tipo_usuario == 'Administrador' || $tipo_usuario == 'Organización'): ?>
                <a href="necesidades.php" class="btn btn-primary m-2">Gestionar Necesidades</a>
            <?php endif; ?>
            <?php if ($tipo_usuario == 'Administrador' || $tipo_usuario == 'Donante'): ?>
                <a href="donaciones.php" class="btn btn-primary m-2">Gestionar Donaciones</a>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>