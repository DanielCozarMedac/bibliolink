<?php
session_start();

// 1. Protección de ruta
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

require "sesion/conexion.php";
$correo_sesion = $_SESSION["correo"];

// 2. Obtener datos actuales del usuario
$sql = "SELECT * FROM usuarios WHERE email = '$correo_sesion'";
$resultado = $_conexion->query($sql);
$usuario = $resultado->fetch_assoc();

// 3. Lógica de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = $_POST["nombre"];
    $nueva_suscripcion = $_POST["suscripcion"];

    // Actualizamos en la base de datos
    $sql_update = "UPDATE usuarios 
                   SET nombre_usuario = '$nuevo_nombre', tipo_suscripcion = '$nueva_suscripcion' 
                   WHERE email = '$correo_sesion'";

    if ($_conexion->query($sql_update)) {
        $mensaje = "Perfil actualizado correctamente.";
        // Actualizamos la variable local para que el formulario muestre los cambios
        $usuario['nombre_usuario'] = $nuevo_nombre;
        $usuario['tipo_suscripcion'] = $nueva_suscripcion;
        // También actualizamos la sesión de admin por si cambió el rol
        $_SESSION["admin"] = $nueva_suscripcion;
    } else {
        $error = "Error al actualizar el perfil.";
    }
}
// 4. Obtener el ID del usuario para filtrar sus libros
$id_usuario_actual = $usuario['id_usuario']; 

// 5. Consultar SOLO los libros que pertenecen a este usuario
$sql_mis_libros = "SELECT * FROM libros WHERE id_usuario = '$id_usuario_actual'";
$mis_libros = $_conexion->query($sql_mis_libros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Bibliolink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="index.php" class="navbar-brand">Bibliolink 📚</a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-outline-light btn-sm me-2">Volver al Inicio</a>
                <a href="sesion/logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Gestionar Mi Perfil</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if(isset($mensaje)): ?>
                            <div class="alert alert-success"><?php echo $mensaje; ?></div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Correo Electrónico (No editable)</label>
                                <input type="text" class="form-control" value="<?php echo $usuario['email']; ?>" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nombre de Usuario</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo $usuario['nombre_usuario']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipo de Suscripción</label>
                                <select name="suscripcion" class="form-control">
                                    <option value="gratuita" <?php if($usuario['tipo_suscripcion'] == 'gratuita') echo 'selected'; ?>>Gratuita</option>
                                    <option value="premium" <?php if($usuario['tipo_suscripcion'] == 'premium') echo 'selected'; ?>>Premium</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-white rounded shadow-sm">
                    <h5>¿Por qué no puedo cambiar mi correo?</h5>
                    <p class="text-muted small">El correo electrónico es tu identificador único en Bibliolink. Si necesitas cambiarlo, por favor contacta con soporte.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Mis Libros subidos</h3>
            <a href="libros_nuevo.php" class="btn btn-success">Añadir Libro +</a>
        </div>

       <table class="table table-hover bg-white shadow-sm rounded">
    <thead class="table-dark">
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Modalidad</th> <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if($mis_libros->num_rows > 0): ?>
            <?php while($libro = $mis_libros->fetch_assoc()): ?>
            <tr>
                <td><?php echo $libro['titulo']; ?></td>
                <td><?php echo $libro['autor']; ?></td>
                <td>
                    <?php if($libro['tipo_oferta'] == 'venta'): ?>
                        <span class="badge bg-info text-dark">Venta</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Intercambio</span>
                    <?php endif; ?>
                </td>
                <td><?php echo $libro['precio']; ?>€</td>
                <td>
                    <a href="libros_editar.php?id=<?php echo $libro['id_libro']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="libros_borrar.php?id=<?php echo $libro['id_libro']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('¿Seguro?')">Borrar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No has subido libros todavía.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
    </div>
</div>
    </div>

</body>
</html>