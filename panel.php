<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
require "conexion.php";

// Obtener software con licencias vencidas
$sql_vencidas = "SELECT e.nombre_equipo, s.nombre_software, s.version, s.fecha_vencimiento
                 FROM software s
                 INNER JOIN equipos e ON e.id_equipo = s.id_equipo
                 WHERE s.fecha_vencimiento IS NOT NULL 
                 AND s.fecha_vencimiento < CURDATE()";
$vencidas = $conn->query($sql_vencidas);

// Licencias por vencer en 30 días
$sql_proximas = "SELECT e.nombre_equipo, s.nombre_software, s.version, s.fecha_vencimiento
                 FROM software s
                 INNER JOIN equipos e ON e.id_equipo = s.id_equipo
                 WHERE s.fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
$proximas = $conn->query($sql_proximas);

// Software crítico sin licencia válida
$sql_critico = "SELECT e.nombre_equipo, s.nombre_software, s.version, s.fecha_vencimiento
                FROM software s
                INNER JOIN equipos e ON e.id_equipo = s.id_equipo
                WHERE s.es_critico = 1 
                AND (s.fecha_vencimiento IS NULL OR s.fecha_vencimiento < CURDATE())";
$criticos = $conn->query($sql_critico);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="css/stylePanel.css">
</head>
<body>
    <div id="panel">
        <h1>📊 Panel de Control - Estado de Software</h1>
        <a href="menu.php" class="botonvolver">⬅ Volver al menú</a>

        <div class="alertas">
            <h2>🚨 Licencias Vencidas</h2>
            <?php if ($vencidas->num_rows > 0): ?>
                <ul class="alerta-roja">
                <?php while($row = $vencidas->fetch_assoc()): ?>
                    <li><b><?= $row['nombre_equipo'] ?></b> - <?= $row['nombre_software'] ?> (<?= $row['version'] ?>) venció el <?= $row['fecha_vencimiento'] ?></li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="ok">✅ No hay licencias vencidas.</p>
            <?php endif; ?>
        </div>

        <div class="alertas">
            <h2>⚠️ Licencias próximas a vencer</h2>
            <?php if ($proximas->num_rows > 0): ?>
                <ul class="alerta-amarilla">
                <?php while($row = $proximas->fetch_assoc()): ?>
                    <li><b><?= $row['nombre_equipo'] ?></b> - <?= $row['nombre_software'] ?> vence el <?= $row['fecha_vencimiento'] ?></li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="ok">✅ No hay licencias por vencer en 30 días.</p>
            <?php endif; ?>
        </div>

        <div class="alertas">
            <h2>🔴 Software Crítico sin licencia válida</h2>
            <?php if ($criticos->num_rows > 0): ?>
                <ul class="alerta-critica">
                <?php while($row = $criticos->fetch_assoc()): ?>
                    <li><b><?= $row['nombre_equipo'] ?></b> - <?= $row['nombre_software'] ?> (crítico sin licencia válida)</li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="ok">✅ Todo el software crítico está en regla.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
