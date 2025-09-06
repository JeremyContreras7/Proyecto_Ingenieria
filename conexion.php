<?php
$host = "localhost";
$dbname = "gestion_licencias";
$usuario = "root";   // Por defecto en XAMPP
$password = "";      // Por defecto vacío en XAMPP

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    die("❌ Error en la conexión: " . $e->getMessage());
}
?>
