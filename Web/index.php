<?php
include "conexion.php";
$stmt = $conn->prepare("SELECT n.*, o.nombre_org FROM necesidades n 
    JOIN organizacion o ON n.id_organizacion = o.id_organizacion 
    WHERE n.estado = 'pendiente' ORDER BY n.fecha_creacion DESC LIMIT 6");
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYNI - Apoya a tu Comunidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">AYNI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agregar_usuario.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="agregar_necesidad.php">Crear Necesidad</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center text-white d-flex align-items-center" style="background-image: url('https://via.placeholder.com/1200x400'); background-size: cover; height: 60vh;">
        <div class="container">
            <h1 class="display-4 fw-bold">Apoya a tu Comunidad con AYNI</h1>
            <p class="lead">Conecta con ollas comunes, orfanatos y más para hacer una diferencia.</p>
            <a href="login.php" class="btn btn-primary btn-lg">Donar Ahora</a>
        </div>
    </section>

    <!-- Necesidades Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Necesidades Actuales</h2>
            <div class="row g-4">
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Necesidad">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['tipo_donacion']); ?></h5>
                                    <p class="card-text"><strong>Organización:</strong> <?php echo htmlspecialchars($row['nombre_org']); ?></p>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($row['descripcion'], 0, 100)); ?>...</p>
                                    <p class="card-text"><small class="text-muted">Publicado: <?php echo $row['fecha_creacion']; ?></small></p>
                                    <a href="login.php" class="btn btn-primary">Donar</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No hay necesidades publicadas en este momento.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>AYNI</h5>
                    <p>Plataforma para conectar donantes con comunidades necesitadas.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="login.php" class="text-white">Iniciar Sesión</a></li>
                        <li><a href="agregar_usuario.php" class="text-white">Registrarse</a></li>
                        <li><a href="agregar_necesidad.php" class="text-white">Crear Necesidad</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p>Correo: info@ayni.com</p>
                    <p>Teléfono: +51 123 456 789</p>
                </div>
            </div>
            <hr class="bg-white">
            <p class="text-center mb-0">© 2025 AYNI - Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>