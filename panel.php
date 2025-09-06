<?php
session_start();
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["ADMIN","ENCARGADO"])) {
    header("Location: index.php");
    exit();
}

require "conexion.php";

// Variables de sesión
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'] ?? null;

// Condición extra para encargados
$filtro = "";
if ($rol === "ENCARGADO" && $establecimiento) {
    $filtro = " AND e.establecimiento = '" . $conn->real_escape_string($establecimiento) . "'";
}

// ================== CONSULTAS ==================

// Licencias vencidas
$sql_vencidas = "SELECT e.nombre_equipo, s.nombre_software, s.version, s.fecha_vencimiento
                 FROM software s
                 INNER JOIN equipos e ON e.id_equipo = s.id_equipo
                 WHERE s.fecha_vencimiento IS NOT NULL 
                 AND s.fecha_vencimiento < CURDATE() $filtro";
$vencidas = $conn->query($sql_vencidas);

// Licencias por vencer
$sql_proximas = "SELECT e.nombre_equipo, s.nombre_software, s.version, s.fecha_vencimiento
                 FROM software s
                 INNER JOIN equipos e ON e.id_equipo = s.id_equipo
                 WHERE s.fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) $filtro";
$proximas = $conn->query($sql_proximas);

// Software crítico sin licencia válida
$sql_critico = "SELECT e.nombre_equipo, s.nombre_software, s.version, s.fecha_vencimiento
                FROM software s
                INNER JOIN equipos e ON e.id_equipo = s.id_equipo
                WHERE s.es_critico = 1 
                AND (s.fecha_vencimiento IS NULL OR s.fecha_vencimiento < CURDATE()) $filtro";
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
        <?php if ($rol === "ENCARGADO"): ?>
            <h2>🏫 Establecimiento: <?= htmlspecialchars($establecimiento) ?></h2>
        <?php endif; ?>

        <a href="menu.php" class="botonvolver">⬅ Volver al menú</a>

        <div class="contenedor-tarjetas">
            <!-- Licencias vencidas -->
            <div class="tarjeta roja">
                <h2>🚨 Licencias Vencidas</h2>
                <?php if ($vencidas->num_rows > 0): ?>
                    <ul>
                    <?php while($row = $vencidas->fetch_assoc()): ?>
                        <li><b><?= $row['nombre_equipo'] ?></b> - <?= $row['nombre_software'] ?> 
                            (<?= $row['version'] ?>) venció el <?= $row['fecha_vencimiento'] ?></li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>✅ No hay licencias vencidas.</p>
                <?php endif; ?>
            </div>

            <!-- Licencias próximas -->
            <div class="tarjeta amarilla">
                <h2>⚠️ Próximas a vencer</h2>
                <?php if ($proximas->num_rows > 0): ?>
                    <ul>
                    <?php while($row = $proximas->fetch_assoc()): ?>
                        <li><b><?= $row['nombre_equipo'] ?></b> - <?= $row['nombre_software'] ?> vence el <?= $row['fecha_vencimiento'] ?></li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>✅ No hay licencias próximas a vencer.</p>
                <?php endif; ?>
            </div>

            <!-- Software crítico -->
            <div class="tarjeta naranja">
                <h2>🔴 Software Crítico</h2>
                <?php if ($criticos->num_rows > 0): ?>
                    <ul>
                    <?php while($row = $criticos->fetch_assoc()): ?>
                        <li><b><?= $row['nombre_equipo'] ?></b> - <?= $row['nombre_software'] ?> 
                            (crítico sin licencia válida)</li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>✅ Todo el software crítico está en regla.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
