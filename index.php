<?php
// Evitar el caching para mayor seguridad en sesiones
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>Gestión de Licencias - Inicio de Sesión</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/stylelogin.css" />
</head>

<body class="homepage is-preload">
    <div id="page-wrapper">
        <center>
            <br><br>
            <img src="img/logo.png" alt="Logo Institución">
        </center>

        <center>
            <!--Formulario de inicio de sesión -->
            <form id="frmlogin" class="grupo-entradas" method="POST" action="validar.php">
                <h1>Sistema de Gestión de Licencias</h1>   
                <input type="text" class="cajaentradatexto" placeholder="&#129492; Nombre Completo" name="txtnombre" required>
                <input type="email" class="cajaentradatexto" placeholder="&#128273; Correo Institucional" name="txtusuario" required>
                <input type="password" class="cajaentradatexto" placeholder="&#128274; Contraseña" name="txtpassword" id="txtpassword" required>
                <input type="checkbox" onclick="verpassword()"> 
                <p id="mostrarC">Mostrar contraseña</p>

                <select name="rol" required>
                    <option disabled selected value="">Seleccionar Rol</option>
                    <option value="ADMIN">Administrador Central</option>
                    <option value="ENCARGADO">Encargado de Establecimiento</option>
                </select>

                <button type="submit" class="botonenviar" name="btnloginx">Iniciar Sesión</button>
            </form>

            <p style="margin-top: 15px;">¿No tienes cuenta?</p>
            <a href="registrar.php" class="botonregistro">Crear una cuenta</a>
        </center>
    </div>

    <script>
        function verpassword() {
            var x = document.getElementById("txtpassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
