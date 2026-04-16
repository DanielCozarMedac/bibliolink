<?php
// 1. Iniciamos sesión y protegemos la página
session_start();

// Si no existe la sesión del correo, mandamos al usuario de patitas al login
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

// 2. Incluimos la conexión (ajusta la ruta según tu carpeta)
require "sesion/conexion.php";
// 3. Consultamos los libros y el nombre del dueño (JOIN)
$consulta = "SELECT libros.*, usuarios.nombre_usuario 
             FROM libros 
             JOIN usuarios ON libros.id_usuario = usuarios.id_usuario";
$resultado = $_conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bibliolink - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">Bibliolink 📚</span>
            <div class="d-flex">
                <span class="text-white me-3">Bienvenido, <?php echo $_SESSION["correo"]; ?></span>
                <a href="perfil.php" class="btn btn-outline-info btn-sm me-2">Mi Perfil</a> <a href="sesion/logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Libros Disponibles</h2>

        <div class="row">
            <?php while ($libro = $resultado->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $libro['titulo']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $libro['autor']; ?></h6>
                            <p class="card-text"><?php echo $libro['descripcion']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary"><?php echo ucfirst($libro['tipo_oferta']); ?></span>
                                <span class="fw-bold text-success"><?php echo $libro['precio']; ?>€</span>
                            </div>
                        </div>
                        <div class="card-footer text-muted small">
                            Subido por: <?php echo $libro['nombre_usuario']; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>

</html>