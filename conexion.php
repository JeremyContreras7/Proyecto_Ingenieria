<?php
$host = "localhost";
$usuario = "root";   // Por defecto en XAMPP
$password = "";      // Por defecto vacío en XAMPP
$bd = "gestion_licencias";

$conexion = new mysqli($host, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("❌ Error en la conexión: " . $conexion->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos";
}
?>
