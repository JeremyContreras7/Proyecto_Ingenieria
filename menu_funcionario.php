<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "USUARIO") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Usuario</title>
    <link rel="stylesheet" href="css/stylemenu.css">
</head>
<body>
    <h1>🙋 Bienvenido <?php echo $_SESSION['nombre']; ?> </h1>
    <nav>
        <ul>
            <li><a href="mis_software.php">📦 Ver software disponible</a></li>
            <li><a href="mis_licencias.php">📑 Estado de mis licencias</a></li>
            <li><a href="reportar_problema.php">⚠️ Reportar problemas al Encargado</a></li>
            <li><a href="logout.php">🚪 Cerrar sesión</a></li>
        </ul>
    </nav>
</body>
</html>
