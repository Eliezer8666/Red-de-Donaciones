<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] != 'Administrador') {
    header("Location: login.php");
    exit();
}
include "conexion.php";

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
header("Location: usuarios.php");
exit();
?>