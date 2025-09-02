<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/stylelogin.css" />
</head>
<body>
    <center>
        <h1>Registrar Nuevo Usuario</h1>
        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre Completo" required><br>
            <input type="email" name="correo" placeholder="Correo Institucional" required><br>
            <input type="password" name="pass" placeholder="Contraseña" required><br>

            <!-- Selección de Rol -->
            <select name="rol" id="rol" required onchange="toggleEncargado()">
                <option disabled selected>Seleccionar Rol</option>
                <option value="ADMIN">Administrador</option>
                <option value="ENCARGADO">Encargado Informático</option>
                <option value="USUARIO">Personal Escolar</option>
            </select><br>

            <input type="text" name="establecimiento" placeholder="Establecimiento" required><br>

            <!-- Tipo de Encargado (solo si es USUARIO) -->
            <select name="tipo_encargado" id="tipo_encargado" disabled>
                <option disabled selected>Tipo de Encargado</option>
                <option value="INFORMATICA">Informática</option>
                <option value="ACADEMICA">Académica</option>
                <option value="ADMINISTRATIVA">Administrativa</option>
                <option value="DIRECCION">Dirección</option>
                <option value="CONVIVENCIA">Convivencia Escolar</option>
            </select><br>

            <button type="submit" name="btnregistrar">Registrar Usuario</button>
        </form>
    </center>

    <script>
        // Activa o desactiva el campo "tipo_encargado"
        function toggleEncargado() {
            let rol = document.getElementById("rol").value;
            let encargadoSelect = document.getElementById("tipo_encargado");

            if (rol === "USUARIO") {
                encargadoSelect.disabled = false;
                encargadoSelect.required = true;
            } else {
                encargadoSelect.disabled = true;
                encargadoSelect.required = false;
                encargadoSelect.selectedIndex = 0;
            }
        }
    </script>
</body>
</html>

<?php
// =========================
// 🔹 Conexión con PDO
// =========================
$host = "localhost";
$dbname = "gestion_licencias";
$usuario = "root";   // Usuario por defecto en XAMPP
$password = "";      // Contraseña vacía en XAMPP

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    die("❌ Error en la conexión: " . $e->getMessage());
}

// =========================
// 🔹 Lógica de Registro
// =========================
if (isset($_POST['btnregistrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];
    $establecimiento = $_POST['establecimiento'];
    $tipo_encargado = ($rol === "USUARIO") ? $_POST['tipo_encargado'] : null;

    try {
        $sql = "INSERT INTO usuarios (nombre, correo, pass, rol, establecimiento, tipo_encargado) 
                VALUES (:nombre, :correo, :pass, :rol, :establecimiento, :tipo_encargado)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':establecimiento', $establecimiento);
        $stmt->bindParam(':tipo_encargado', $tipo_encargado);

        $stmt->execute();
        echo "<p style='color:green; text-align:center;'>✅ Usuario registrado correctamente.</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red; text-align:center;'>❌ Error: " . $e->getMessage() . "</p>";
    }
}
?>
