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

            <!-- Selección de Tipo de Encargado -->
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
        function toggleEncargado() {
            let rol = document.getElementById("rol").value;
            let encargadoSelect = document.getElementById("tipo_encargado");

            if (rol === "USUARIO") {
                encargadoSelect.disabled = false; // Se activa
                encargadoSelect.required = true;
            } else {
                encargadoSelect.disabled = true;  // Se desactiva
                encargadoSelect.required = false;
                encargadoSelect.selectedIndex = 0; // Vuelve a opción por defecto
            }
        }
    </script>
</body>
</html>

<?php
// Lógica de registro
include("conexion.php"); // asegúrate de tener tu conexión aquí

if (isset($_POST['btnregistrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];
    $establecimiento = $_POST['establecimiento'];
    $tipo_encargado = ($_POST['rol'] === "USUARIO") ? $_POST['tipo_encargado'] : null;

    $sql = "INSERT INTO usuarios (nombre, correo, pass, rol, establecimiento, tipo_encargado) 
            VALUES ('$nombre','$correo','$pass','$rol','$establecimiento','$tipo_encargado')";

    if ($conexion->query($sql) === TRUE) {
        echo "<p>✅ Usuario registrado correctamente.</p>";
    } else {
        echo "<p>❌ Error: " . $conexion->error . "</p>";
    }
}
?>
