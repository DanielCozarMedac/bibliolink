<?php
session_start();

// 1. Protección de ruta
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

require "sesion/conexion.php";
$correo_sesion = $_SESSION["correo"];

// 2. Obtener el ID del usuario actual (seguridad)
$res_user = $_conexion->query("SELECT id_usuario FROM usuarios WHERE email = '$correo_sesion'");
$usuario = $res_user->fetch_assoc();
$id_usuario = $usuario['id_usuario'];

$error = null;
$mensaje = null;

// 3. Cargar los datos actuales del libro
if (isset($_GET["id"])) {
    $id_libro = $_GET["id"];
    
    // Solo buscamos el libro si el id_usuario coincide (Seguridad sugerida por tu compañero)
    $sql_libro = "SELECT * FROM libros WHERE id_libro = '$id_libro' AND id_usuario = '$id_usuario'";
    $res_libro = $_conexion->query($sql_libro);
    
    if ($res_libro->num_rows == 1) {
        $libro = $res_libro->fetch_assoc();
    } else {
        // Si no existe o no es suyo, lo mandamos al perfil
        header("location: perfil.php");
        exit();
    }
} else {
    header("location: perfil.php");
    exit();
}

// 4. Lógica de actualización al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $tipo_oferta = $_POST["tipo_oferta"];

    if (empty($titulo) || empty($autor)) {
        $error = "El título y el autor son obligatorios.";
    } else {
        // Actualizamos los datos
        $sql_update = "UPDATE libros SET 
                        titulo = '$titulo', 
                        autor = '$autor', 
                        descripcion = '$descripcion', 
                        precio = '$precio', 
                        tipo_oferta = '$tipo_oferta' 
                       WHERE id_libro = '$id_libro' AND id_usuario = '$id_usuario'";

        if ($_conexion->query($sql_update)) {
            header("location: perfil.php?mensaje=editado");
            exit();
        } else {
            $error = "Error al actualizar el libro.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Libro - Bibliolink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="index.php" class="navbar-brand">Bibliolink 📚</a>
            <div class="d-flex">
                <a href="perfil.php" class="btn btn-outline-light btn-sm">Volver a Mi Perfil</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Editar Información del Libro</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" name="titulo" class="form-control" value="<?php echo $libro['titulo']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <input type="text" name="autor" class="form-control" value="<?php echo $libro['autor']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3"><?php echo $libro['descripcion']; ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio (€)</label>
                                    <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $libro['precio']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de Oferta</label>
                                    <select name="tipo_oferta" class="form-select">
                                        <option value="venta" <?php if($libro['tipo_oferta'] == 'venta') echo 'selected'; ?>>Venta</option>
                                        <option value="intercambio" <?php if($libro['tipo_oferta'] == 'intercambio') echo 'selected'; ?>>Intercambio</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-warning btn-lg">Guardar Cambios</button>
                                <a href="perfil.php" class="btn btn-link text-secondary">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>