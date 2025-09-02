<?php
include('conexion.php'); // conexión PostgreSQL

session_start();

// Recibir datos del formulario
$correo   = $_POST["txtusuario"] ?? '';
$pass     = $_POST["txtpassword"] ?? '';
$nombre   = $_POST["txtnombre"] ?? '';
$rol      = $_POST["rol"] ?? '';
$establecimiento = $_POST["establecimiento"] ?? '';
$tipo_encargado  = $_POST["tipo_encargado"] ?? '';

// ----------- LOGIN -----------
if (isset($_POST["btnloginx"])) {
    $sql = "SELECT * FROM usuarios WHERE correo = :correo AND nombre = :nombre AND rol = :rol";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':correo' => $correo,
        ':nombre' => $nombre,
        ':rol'    => $rol
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($pass, $usuario['pass'])) {
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol']    = $usuario['rol'];
        $_SESSION['establecimiento'] = $usuario['establecimiento'];
        $_SESSION['tipo_encargado']  = $usuario['tipo_encargado'];

        // Redirigir al menú principal
        header("Location: menu.php");
        exit();
    } else {
        echo "<script>alert('Credenciales incorrectas o rol no válido'); window.location='index.php';</script>";
    }
}

// ----------- REGISTRO DE USUARIO -----------
if (isset($_POST["btnregistrarx"])) {
    // Verificar si el correo ya existe
    $sqlCheck = "SELECT 1 FROM usuarios WHERE correo = :correo";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->execute([':correo' => $correo]);

    if ($stmtCheck->fetch()) {
        echo "<script>alert('El correo ya está registrado: $correo'); window.location='registrar.php';</script>";
        exit();
    }

    // Registrar usuario
    $pass_segura = password_hash($pass, PASSWORD_BCRYPT);
    $sqlInsert = "INSERT INTO usuarios 
                  (correo, pass, nombre, rol, establecimiento, tipo_encargado) 
                  VALUES (:correo, :pass, :nombre, :rol, :establecimiento, :tipo_encargado)";
    $stmtInsert = $conexion->prepare($sqlInsert);

    $ok = $stmtInsert->execute([
        ':correo' => $correo,
        ':pass' => $pass_segura,
        ':nombre' => $nombre,
        ':rol' => $rol,
        ':establecimiento' => $establecimiento,
        ':tipo_encargado' => $tipo_encargado
    ]);

    if ($ok) {
        echo "<script>alert('Usuario registrado correctamente: $nombre - $establecimiento'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar el usuario'); window.location='registrar.php';</script>";
    }
}
?>
