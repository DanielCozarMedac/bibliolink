<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Bibliolink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        require "conexion.php"; // Asegúrate de que la ruta sea correcta
    ?>
</head>
<body>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $tmp_usuario = trim($_POST["usuario"]);
        $tmp_email = trim($_POST["email"]);
        $tmp_contrasena = $_POST["contrasena"];
        $tmp_rol = isset($_POST["rol"]) ? $_POST["rol"] : "";

        // 1. Validación Rol (Corregido: usamos tmp_rol para la comprobación)
        if($tmp_rol == "" || $tmp_rol == "disabled selected"){
            $err_rol = "Escoja un tipo de suscripción";
        } else {
            $rol = $tmp_rol;
        }

        // 2. Validación Usuario
        if($tmp_usuario == ""){
            $err_usuario = "Introduzca un nombre";
        } else {
            $usuario = $tmp_usuario;
        }

        // 3. Validación Email (Nuevo: tu BD lo pide)
        if($tmp_email == ""){
            $err_email = "Introduzca un email";
        } else {
            $email = $tmp_email;
        }

        // 4. Validación Contraseña
        if($tmp_contrasena == ""){
            $err_contrasena = "Introduzca una contraseña";
        } else {
            $contrasena = $tmp_contrasena;
        }

        // 5. Inserción en BD
        if(isset($usuario) && isset($email) && isset($contrasena) && isset($rol)){
            // Encriptamos para máxima seguridad
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
            
            // Ajustado a tus columnas: nombre_usuario, email, contrasena, tipo_suscripcion
            $consulta = "INSERT INTO usuarios (nombre_usuario, email, contrasena, tipo_suscripcion) 
                         VALUES ('$usuario', '$email', '$contrasena_cifrada', '$rol')";
            
            try {
                if($_conexion->query($consulta)){
                    echo "<div class='alert alert-success mt-3'>¡Registro exitoso! Ya puedes loguearte.</div>";
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) { // Error de duplicado
                    $err_email = "Este correo ya está registrado";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                }
            }
        }
    }
    ?>

    <div class="container mt-5"> 
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 shadow p-4 bg-white rounded">
                <h1 class="text-center mb-4">Crear Cuenta</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="usuario" class="form-control" value="<?php echo $tmp_usuario ?? '' ?>">
                        <?php if(isset($err_usuario)) echo "<small class='text-danger'>$err_usuario</small>"; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $tmp_email ?? '' ?>">
                        <?php if(isset($err_email)) echo "<small class='text-danger'>$err_email</small>"; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control">
                        <?php if(isset($err_contrasena)) echo "<small class='text-danger'>$err_contrasena</small>"; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Suscripción</label>
                        <select name="rol" class="form-select">
                            <option value="disabled selected">-- Seleccione --</option>
                            <option value="gratuita">Gratuita</option>
                            <option value="premium">Premium</option>
                        </select>
                        <?php if(isset($err_rol)) echo "<small class='text-danger'>$err_rol</small>"; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Registrarse</button>
                </form>
                    <p class="text-center mt-4">¿Ya tienes cuenta? <a href="/bibliolink/backend/php/sesion/login.php">Inicia sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>