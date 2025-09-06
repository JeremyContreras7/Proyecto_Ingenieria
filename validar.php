<?php
session_start();
include('conexion.php'); // aquí defines $host, $dbname, $usuario, $password

// =========================
// 🔹 Conexión PDO
// =========================
try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error en la conexión: " . $e->getMessage());
}

// =========================
// 🔹 LOGIN
// =========================
if (isset($_POST['btnloginx'])) {
    $correo = $_POST['txtusuario'];
    $pass = $_POST['txtpassword'];
    $rol   = $_POST['rol'];

    $sql = "SELECT * FROM usuarios WHERE correo = :correo AND rol = :rol LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':rol', $rol);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($pass, $usuario['pass'])) {
        $_SESSION['id_usuario']     = $usuario['id'];
        $_SESSION['nombre']         = $usuario['nombre'];
        $_SESSION['rol']            = $usuario['rol'];
        $_SESSION['establecimiento']= $usuario['establecimiento'];
        $_SESSION['tipo_encargado'] = $usuario['tipo_encargado'];

        // Redirigir según rol
        if ($rol === "ADMIN") {
            header("Location: menu.php");
        } elseif ($rol === "ENCARGADO") {
            header("Location: menu_encargado.php");
        } elseif ($rol === "USUARIO") {
            header("Location: menu_usuario.php");
        }
        exit();
    } else {
        echo "<script>alert('❌ Credenciales incorrectas.'); window.location='index.php';</script>";
    }
}

// =========================
// 🔹 REGISTRO DE NUEVOS USUARIOS
// =========================
if (isset($_POST['btnregistrarx'])) {
    $nombre        = $_POST['nombre'];
    $correo        = $_POST['correo'];
    $pass          = $_POST['pass'];
    $rol           = $_POST['rol'];
    $establecimiento = $_POST['establecimiento'];
    $tipo_encargado  = ($_POST['rol'] === "USUARIO") ? $_POST['tipo_encargado'] : null;

    // Verificar si ya existe el correo
    $sql = "SELECT COUNT(*) FROM usuarios WHERE correo = :correo";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $existe = $stmt->fetchColumn();

    if ($existe == 0) {
        $pass_segura = password_hash($pass, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nombre, correo, pass, rol, establecimiento, tipo_encargado) 
                VALUES (:nombre, :correo, :pass, :rol, :establecimiento, :tipo_encargado)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':pass', $pass_segura);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':establecimiento', $establecimiento);
        $stmt->bindParam(':tipo_encargado', $tipo_encargado);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Usuario registrado correctamente: $nombre - $establecimiento'); window.location='registrar.php';</script>";
        } else {
            echo "<script>alert('❌ Error al registrar el usuario.'); window.location='registrar.php';</script>";
        }
    } else {
        echo "<script>alert('⚠️ El correo ya está registrado: $correo'); window.location='registrar.php';</script>";
    }
}
$_SESSION['establecimiento'] = $usuario['establecimiento'];
$_SESSION['rol'] = $usuario['rol'];

?>
