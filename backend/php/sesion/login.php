<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliolink</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        require "conexion.php";
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $tmp_correo = $_POST["correo"];
        $tmp_contrasena = $_POST["contrasena"];

        // Validación de campos vacíos
        if($tmp_contrasena == "") $err_contrasena = "Introduce una contraseña";
        else $contrasena = $tmp_contrasena;

        if($tmp_correo == "") $err_correo = "Introduce un correo";
        else $correo = $tmp_correo;

        if(isset($correo) && isset($contrasena)){
            $consulta = "SELECT * FROM usuarios WHERE email = '$correo'";
            $resultado = $_conexion -> query($consulta);

            if($resultado -> num_rows === 0){
                echo "<div class='alert alert-danger'>El correo no existe en la base de datos</div>";
            } else {
                $user_info = $resultado -> fetch_assoc();
                
                // password_verify descifra el hash de la BD y lo compara con lo que escribió el usuario
               if(!password_verify($contrasena, $user_info["contrasena"])){
                $nombre = $user_info["nombre_usuario"];
                echo "<div class='alert alert-danger'>Contraseña incorrecta para el usuario $nombre</div>";
                } else {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION["correo"] = $correo;
                    // Asegúrate de que la columna 'tipo_suscripcion' o 'admin' exista en tu SQL
                    $_SESSION["admin"] = $user_info["tipo_suscripcion"]; 

                    header("location:../index.php");
                    exit();
                }
            }
        }
    }
?>
    <div class="container mt-5"> 
        <div class="row justify-content-center"> 
            <div class="col-md-6 col-lg-4">
                <h1 class="text-center mb-4">Iniciar sesión</h1> 
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="text" name="correo" class="form-control">
                        <?php if(isset($err_correo)) echo "<div class = 'alert alert-danger'>$err_correo</div>"; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control">
                        <?php if(isset($err_contrasena)) echo "<div class = 'alert alert-danger'>$err_contrasena</div>"; ?>
                    </div>

                    <div class="mb-3">
                        <input type="submit" value="Iniciar sesión" class="btn btn-primary w-100">
                    </div>
                </form>
                <h5 class="text-center mt-4  mb-3">Si no tienes cuenta, registrate aquí</h5>
                <a href="signup.php" class="btn btn-secondary w-100">Registrarse</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>