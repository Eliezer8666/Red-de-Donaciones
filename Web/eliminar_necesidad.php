<?php
session_start();
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['tipo_usuario'], ['Administrador', 'Organización'])) {
    header("Location: login.php");
    exit();
}
include "conexion.php";

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM necesidades WHERE id_necesidad = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
header("Location: necesidades.php");
exit();
?>