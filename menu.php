<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "ADMIN") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="css/stylemenu.css">
</head>
<body>
    <h1>👑 Bienvenido Administrador, <?php echo $_SESSION['nombre']; ?> </h1>
    <nav>
        <ul>
            <li><a href="crear_cuentas.php">➕ Crear cuentas de Encargados o Admins</a></li>
            <li><a href="panel.php">📊 Ver estado de las licencias</a></li>
            <li><a href="alertas.php">⚠️ Alertas de vencimientos</a></li>
            <li><a href="gestionar_licencias.php">✏️ Editar/Eliminar licencias</a></li>
            <li><a href="escuelas.php">🏫 Control Global de Escuelas</a></li>
            <li><a href="logout.php">🚪 Cerrar sesión</a></li>
        </ul>
    </nav>
</body>
</html>
