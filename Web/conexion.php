<?php
$host = "localhost";
$db = "AYNI_Donaciones";
$user = "root";
$pass = "DELFIN";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>