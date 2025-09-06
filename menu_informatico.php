<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "ENCARGADO") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Encargado Informático</title>
    <link rel="stylesheet" href="css/stylemenu.css">
</head>
<body>
    <h1>💻 Bienvenido Encargado, <?php echo $_SESSION['nombre']; ?> </h1>
    <nav>
        <ul>
            <li><a href="crear_usuarios.php">👥 Crear cuentas para funcionarios</a></li>
            <li><a href="registrar_equipos.php">🖥️ Registrar equipos de la escuela</a></li>
            <li><a href="registrar_licencias.php">📑 Ingresar licencias de software</a></li>
            <li><a href="panel.php">📊 Ver estado de las licencias/a></li>
            <li><a href="asociar_software.php">🔗 Asociar software a equipos</a></li>
            <li><a href="foro.php">💬 Foro de comunicación con Admin</a></li>
            <li><a href="logout.php">🚪 Cerrar sesión</a></li>
        </ul>
    </nav>
</body>
</html>
