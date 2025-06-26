<?php
session_start();
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['tipo_usuario'], ['Administrador', 'Donante'])) {
    header("Location: login.php");
    exit();
}
include "conexion.php";
$usuario_id = $_SESSION['usuario']['id_usuario'];

$stmt = $conn->prepare("SELECT id_necesidad, descripcion FROM necesidades WHERE estado = 'pendiente'");
$stmt->execute();
$necesidades = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_necesidad = $_POST['id_necesidad'];
    $cantidad = $_POST['cantidad'];
    $comentario = $_POST['comentario'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("INSERT INTO donaciones (id_usuario, id_necesidad, cantidad, comentario, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $usuario_id, $id_necesidad, $cantidad, $comentario, $estado);
    if ($stmt->execute()) {
        header("Location: donaciones.php");
        exit();
    } else {
        $error = "Error al agregar donación: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYNI - Agregar Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00695c;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">AYNI</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="donaciones.php">Volver</a>
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <h2 class="text-center mb-4">Agregar Donación</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form id="agregar-donacion-form" method="post" class="col-md-6 mx-auto">
            <div class="mb-3">
                <label for="id_necesidad" class="form-label">Necesidad</label>
                <select class="form-select" id="id_necesidad" name="id_necesidad" required>
                    <?php while ($n = $necesidades->fetch_assoc()): ?>
                        <option value="<?php echo $n['id_necesidad']; ?>"><?php echo htmlspecialchars($n['descripcion']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea class="form-control" id="comentario" name="comentario"></textarea>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="enviado">Enviado</option>
                    <option value="recibido">Recibido</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validaciones.js"></script>
</body>
</html>