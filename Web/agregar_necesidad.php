<?php
session_start();
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['tipo_usuario'], ['Administrador', 'Organización'])) {
    header("Location: login.php");
    exit();
}
include "conexion.php";

$stmt = $conn->prepare("SELECT * FROM organizacion");
$stmt->execute();
$orgs = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_org = $_POST['id_organizacion'];
    $tipo = $_POST['tipo_donacion'];
    $desc = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    $stmt = $conn->prepare("INSERT INTO necesidades (id_organizacion, id_usuario, tipo_donacion, descripcion, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $id_org, $id_usuario, $tipo, $desc, $estado);
    if ($stmt->execute()) {
        header("Location: necesidades.php");
        exit();
    } else {
        $error = "Error al agregar necesidad: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYNI - Agregar Necesidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00695c;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">AYNI</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="necesidades.php">Volver</a>
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <h2 class="text-center mb-4">Agregar Necesidad</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form id="agregar-necesidad-form" method="post" class="col-md-6 mx-auto">
            <div class="mb-3">
                <label for="id_organizacion" class="form-label">Organización</label>
                <select class="form-select" id="id_organizacion" name="id_organizacion" required>
                    <?php while ($org = $orgs->fetch_assoc()): ?>
                        <option value="<?php echo $org['id_organizacion']; ?>"><?php echo htmlspecialchars($org['nombre_org']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo_donacion" class="form-label">Tipo de Donación</label>
                <input type="text" class="form-control" id="tipo_donacion" name="tipo_donacion" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="aprobada">Aprobada</option>
                    <option value="rechazada">Rechazada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validaciones.js"></script>
</body>
</html>