<?php
include('conexion.php');

// Variables recibidas del formulario
$correo   = $_POST["txtusuario"] ?? '';
$pass     = $_POST["txtpassword"] ?? '';
$nombre   = $_POST["txtnombre"] ?? '';
$rol      = $_POST["rol"] ?? '';
$establecimiento = $_POST["establecimiento"] ?? '';
$tipo_encargado  = $_POST["tipo_encargado"] ?? '';

// ----------- LOGIN -----------
if (isset($_POST["btnloginx"])) {
    $queryusuario = mysqli_query($konexta, "SELECT * FROM usuarios 
                                            WHERE correo = '$correo' 
                                            AND nombre = '$nombre' 
                                            AND rol = '$rol'");
    $nr      = mysqli_num_rows($queryusuario);
    $mostrar = mysqli_fetch_array($queryusuario);

    if (($nr == 1) && (password_verify($pass, $mostrar['pass']))) {
        session_start();
        $_SESSION['correo']        = $correo;
        $_SESSION['nombre']        = $nombre;
        $_SESSION['rol']           = $rol;
        $_SESSION['establecimiento'] = $mostrar['establecimiento'];
        $_SESSION['tipo_encargado']  = $mostrar['tipo_encargado'];

        // Redirigir según rol
        if ($rol == "ADMIN") {
            header("Location: /Vista/Admin/Dashboard.php");
        } else if ($rol == "ENCARGADO") {
            header("Location: /Vista/Encargado/Dashboard.php");
        }
        exit();
    } else {
        echo "<script> alert('Credenciales incorrectas o rol no válido.'); window.location= 'index.php' </script>";
    }
}

// ----------- REGISTRO DE NUEVOS USUARIOS -----------
if (isset($_POST["btnregistrarx"])) {
    $queryusuario = mysqli_query($konexta, "SELECT * FROM usuarios WHERE correo = '$correo'");
    $nr = mysqli_num_rows($queryusuario);

    if ($nr == 0) {
        $pass_segura = password_hash($pass, PASSWORD_BCRYPT);
        $queryregistrar = "INSERT INTO usuarios (correo, pass, nombre, rol, establecimiento, tipo_encargado) 
                           VALUES ('$correo', '$pass_segura', '$nombre', '$rol', '$establecimiento', '$tipo_encargado')";

        if (mysqli_query($konexta, $queryregistrar)) {
            echo "<script> alert('Usuario registrado correctamente: $nombre - $establecimiento'); window.location= 'registrar.php' </script>";
        } else {
            echo "<script> alert('Error al registrar el usuario.'); window.location= 'registrar.php' </script>";
        }
    } else {
        echo "<script> alert('El correo ya está registrado: $correo'); window.location= 'registrar.php' </script>";
    }
}
?>
