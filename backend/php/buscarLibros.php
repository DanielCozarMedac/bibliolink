<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require "sesion/conexion.php";

$libros = [];
$mensaje = '';
$titulo_buscado = '';
$mensaje_exito = $_GET['mensaje'] ?? '';
$mensaje_error = $_GET['error'] ?? '';

if (isset($_GET['titulo']) && trim($_GET['titulo']) !== '') {

    $titulo_buscado = trim($_GET['titulo']);
    $busqueda = "%" . $titulo_buscado . "%";

    $sql = "SELECT id_libro, titulo, autor, descripcion, precio, tipo_oferta, disponible 
            FROM libros 
            WHERE titulo LIKE ? 
            ORDER BY titulo ASC";

    $stmt = $_conexion->prepare($sql);

    if (!$stmt) {
        die("❌ Error preparando la consulta: " . $_conexion->error);
    }

    $stmt->bind_param("s", $busqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $libros[] = $row;
    }

    if (empty($libros)) {
        $mensaje = "No se encontraron libros con el título: <strong>" . htmlspecialchars($titulo_buscado) . "</strong>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intercambio de Libros - Buscar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #000000ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #1e2937;
            line-height: 1.6;
        }

        header {
            background: var(--primary);
            color: white;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .search-box {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            margin-bottom: 2rem;
        }

        .search-form {
            display: flex;
            gap: 12px;
            max-width: 700px;
            margin: 0 auto;
        }

        input[type="text"] {
            flex: 1;
            padding: 16px 20px;
            font-size: 1.1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
        }

        input:focus {
            border-color: var(--primary);
            outline: none;
        }

        button {
            padding: 0 35px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            cursor: pointer;
        }

        button:hover {
            background: #1e40af;
        }

        .results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .book-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            transition: all 0.3s;
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 20px -5px rgb(0 0 0 / 0.1);
        }

        .book-card .info {
            padding: 1.4rem;
        }

        .book-card h3 {
            margin-bottom: 10px;
            color: #1e2937;
        }

        .estado {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 10px 0;
        }

        .disponible {
            background: #10b981;
            color: white;
        }

        .intercambiado {
            background: #f59e0b;
            color: white;
        }

        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            font-size: 1.3rem;
            color: #64748b;
        }
    </style>
</head>

<body>

    <header class="bg-dark mb-4">
        <h1>📚 Intercambio de Libros</h1>
        <p>Encuentra libros para intercambiar</p>
    </header>
    <button class="button bg-dark" onclick="window.location.href='index.php'">
        Volver
    </button>
    <div class="container">
        <?php if ($mensaje_exito !== ''): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($mensaje_exito); ?></div>
        <?php endif; ?>

        <?php if ($mensaje_error !== ''): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje_error); ?></div>
        <?php endif; ?>

        <div class="search-box">
            <form method="GET" class="search-form">
                <input
                    type="text"
                    name="titulo"
                    placeholder="Escribe el título del libro..."
                    value="<?php echo htmlspecialchars($titulo_buscado); ?>"
                    required>
                <button type="submit">🔎 Buscar</button>
            </form>
        </div>

        <?php if (isset($_GET['titulo'])): ?>
            <h2>Resultados para: "<?php echo htmlspecialchars($titulo_buscado); ?>"</h2>

            <?php if (!empty($libros)): ?>
                <div class="results">
                    <?php foreach ($libros as $libro): ?>
                        <div class="book-card">
                            <div class="info">
                                <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                                <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                                <?php if (!empty($libro['isbn'])): ?>
                                    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($libro['isbn']); ?></p>
                                <?php endif; ?>

                                <p>
                                    <span class="estado <?php echo (int) $libro['disponible'] === 1 ? 'disponible' : 'intercambiado'; ?>">
                                        <?php echo (int) $libro['disponible'] === 1 ? '✅ Disponible' : '🔄 Intercambiado'; ?>
                                    </span>
                                </p>

                                <?php if (!empty($libro['descripcion'])): ?>
                                    <p style="color:#64748b; font-size:0.95rem;">
                                        <?php echo htmlspecialchars(substr($libro['descripcion'], 0, 140)) . '...'; ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ((int) $libro['disponible'] === 1 && $libro['tipo_oferta'] === 'intercambio'): ?>
                                    <form action="solicitar_intercambio.php" method="post">
                                        <input type="hidden" name="id_libro" value="<?php echo (int) $libro['id_libro']; ?>">
                                        <input type="hidden" name="origen" value="buscarLibros.php">
                                        <input type="hidden" name="titulo" value="<?php echo htmlspecialchars($titulo_buscado); ?>">
                                        <button class="bg-dark" type="submit"
                                            style="margin-top:15px; width:100%; padding:12px; background:#2563eb; color:white; border:none; border-radius:8px; cursor:pointer;">
                                            💱 Quiero intercambiarlo
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="bg-secondary" disabled
                                        style="margin-top:15px; width:100%; padding:12px; color:white; border:none; border-radius:8px;">
                                        No disponible para intercambio
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

</body>

</html>

<?php $_conexion->close(); ?>