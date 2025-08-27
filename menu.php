<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="css/styleMenu.css">
</head>
<body>
    <div id="menu-wrapper">
        <h1>Menú Principal</h1>
        <p>Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong></p>
        
        <div class="menu-grid">
            <a href="registro_usuario.php" class="menu-item">👤 Registro de Usuarios</a>
            <a href="registrar_equipo.php" class="menu-item">💻 Registro de Equipos</a>
            <a href="consulta_inventario.php" class="menu-item">📊 Consultar Inventario</a>
            <a href="configuracion.php" class="menu-item">⚙️ Configuración</a>
            <a href="logout.php" class="menu-item logout">🚪 Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
