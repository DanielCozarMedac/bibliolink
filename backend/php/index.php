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
$mensaje_exito = $_GET["mensaje"] ?? "";
$mensaje_error = $_GET["error"] ?? "";

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
            <div>
                <button onclick="window.location.href='buscarLibros.php'">
                    Buscar
                </button>
            </div>
            <div class="d-flex">
                <span class="text-white me-3">Bienvenido, <?php echo $_SESSION["correo"]; ?></span>
                <a href="perfil.php" class="btn btn-outline-info btn-sm me-2">Mi Perfil</a> <a href="sesion/logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if ($mensaje_exito !== ""): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($mensaje_exito); ?></div>
        <?php endif; ?>

        <?php if ($mensaje_error !== ""): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje_error); ?></div>
        <?php endif; ?>

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
                            <?php if ((int) $libro['disponible'] === 1 && $libro['tipo_oferta'] === 'intercambio'): ?>
                                <form action="solicitar_intercambio.php" method="post" class="mt-3">
                                    <input type="hidden" name="id_libro" value="<?php echo (int) $libro['id_libro']; ?>">
                                    <input type="hidden" name="origen" value="index.php">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Solicitar intercambio</button>
                                </form>
                            <?php elseif ($libro['tipo_oferta'] === 'intercambio'): ?>
                                <button class="btn btn-secondary btn-sm w-100 mt-3" disabled>No disponible</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>

</html>
