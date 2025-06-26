<?php
session_start();
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['tipo_usuario'], ['Administrador', 'Donante'])) {
    header("Location: login.php");
    exit();
}
include "conexion.php";

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM donaciones WHERE id_donacion = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
header("Location: donaciones.php");
exit();
?>