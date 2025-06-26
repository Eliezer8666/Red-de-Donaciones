<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] != 'Administrador') {
    header("Location: login.php");
    exit();
}
include "conexion.php";

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $tipo = $_POST['tipo_usuario'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, tipo_usuario = ?, estado = ? WHERE id_usuario = ?");
    $stmt->bind_param("ssssi", $nombre, $correo, $tipo, $estado, $id);
    if ($stmt->execute()) {
        header("Location: usuarios.php");
        exit();
    } else {
        $error = "Error al actualizar usuario: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYNI - Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00695c;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">AYNI</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="usuarios.php">Volver</a>
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <h2 class="text-center mb-4">Editar Usuario</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form id="editar-usuario-form" method="post" class="col-md-6 mx-auto">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($data['correo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="Donante" <?php echo $data['tipo_usuario'] == 'Donante' ? 'selected' : ''; ?>>Donante</option>
                    <option value="Organización" <?php echo $data['tipo_usuario'] == 'Organización' ? 'selected' : ''; ?>>Organización</option>
                    <option value="Administrador" <?php echo $data['tipo_usuario'] == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="activo" <?php echo $data['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                    <option value="inactivo" <?php echo $data['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validaciones.js"></script>
</body>
</html>