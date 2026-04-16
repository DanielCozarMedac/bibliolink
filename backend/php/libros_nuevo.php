<?php
session_start();

// 1. Protección: solo usuarios registrados
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

require "sesion/conexion.php";
$correo_sesion = $_SESSION["correo"];

// 2. Obtener el ID del usuario actual para vincular el libro
$res_user = $_conexion->query("SELECT id_usuario FROM usuarios WHERE email = '$correo_sesion'");
$usuario = $res_user->fetch_assoc();
$id_usuario = $usuario['id_usuario'];

$error = null;

// 3. Lógica al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $tipo_oferta = $_POST["tipo_oferta"];

    // Validación básica
    if (empty($titulo) || empty($autor)) {
        $error = "El título y el autor son obligatorios.";
    } else {
        // 4. Insertar en la base de datos (RF-6)
        $sql_insert = "INSERT INTO libros (titulo, autor, descripcion, precio, tipo_oferta, id_usuario) 
                       VALUES ('$titulo', '$autor', '$descripcion', '$precio', '$tipo_oferta', '$id_usuario')";

        if ($_conexion->query($sql_insert)) {
            // Si sale bien, volvemos al perfil
            header("location: perfil.php?mensaje=creado");
            exit();
        } else {
            $error = "Error al guardar el libro: " . $_conexion->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Libro - Bibliolink</title>
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
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Publicar un Nuevo Libro</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Título del Libro</label>
                                <input type="text" name="titulo" class="form-control" placeholder="Ej: El Quijote" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <input type="text" name="autor" class="form-control" placeholder="Ej: Miguel de Cervantes" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Cuéntanos un poco sobre el libro..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio (€)</label>
                                    <input type="number" step="0.01" name="precio" class="form-control" value="0.00">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de Oferta</label>
                                    <select name="tipo_oferta" class="form-select">
                                        <option value="venta">Venta</option>
                                        <option value="intercambio">Intercambio</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-success btn-lg">Publicar Libro</button>
                                <a href="perfil.php" class="btn btn-link text-secondary">Descartar y volver</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>