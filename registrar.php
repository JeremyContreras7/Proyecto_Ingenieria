<?php
// Evitar caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>Registro de Usuario</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="css/styleRegistro.css" />
</head>

<body class="homepage is-preload">
    <div id="page-wrapper">
        <center>
            <img src="img/logo.png" alt="Logo Institución">
        </center>

        <center>
            <!--Formulario de registro de usuario -->
            <form id="frmregistro" class="grupo-entradas" method="POST" action="validar.php">
                <h1>Registrar Nuevo Usuario</h1>   

                <input type="text" class="cajaentradatexto" placeholder="&#129492; Nombre Completo" name="txtnombre" required>

                <input type="email" class="cajaentradatexto" placeholder="&#128273; Correo Institucional" name="txtusuario" required>

                <input type="password" class="cajaentradatexto" placeholder="&#128274; Contraseña" name="txtpassword" id="txtpassword" required>
                <input type="checkbox" onclick="verpassword()"> 
                <p id="mostrarC">Mostrar contraseña</p>

                <!-- Selección de rol -->
                <select name="rol" required>
                    <option disabled selected value="">Seleccionar Rol</option>
                    <option value="ADMIN">Administrador Central</option>
                    <option value="ENCARGADO">Encargado de Establecimiento</option>
                </select>

                <!-- Campo de establecimiento -->
                <input type="text" class="cajaentradatexto" placeholder="🏫 Nombre del Establecimiento" name="establecimiento" required>

                <!-- Tipo de encargado -->
                <select name="tipo_encargado" required>
                    <option disabled selected value="">Tipo de Encargado</option>
                    <option value="INFORMATICA">Encargado de Informática</option>
                    <option value="ACADEMICA">Encargado Académico</option>
                    <option value="ADMINISTRATIVA">Encargado Administrativo</option>
                </select>

                <button type="submit" class="botonenviar" name="btnregistrarx">Registrar Usuario</button>
            </form>
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
