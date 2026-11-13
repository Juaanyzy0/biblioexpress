<?php
// Incluimos la conexión a la base de datos
require_once "conexion.php";

// Consultamos todos los libros ordenados desde el más reciente
$sql = "SELECT * FROM libro ORDER BY id_libro DESC";
$stmt = $pdo->query($sql);
$libros = $stmt->fetchAll();

// Capturamos mensajes enviados por GET luego de crear, editar o eliminar
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : "";
$error   = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioExpress - Listado de Libros</title>
    <!-- Bootstrap 5 por CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">BiblioExpress</h1>
            <small class="text-muted">Taller CRUD de Libros con PHP y PDO</small>
        </div>
        <a href="crear.php" class="btn btn-primary">+ Agregar Nuevo Libro</a>
    </div>

    <!-- Alertas para mostrar confirmación o errores al usuario -->
    <?php if ($mensaje !== ""): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <!-- Tabla con el listado de libros -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>ISBN</th>
                            <th>Año</th>
                            <th>Idioma</th>
                            <th>Páginas</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($libros) > 0): ?>
                            <?php foreach ($libros as $libro): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($libro['id_libro']); ?></td>
                                    <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($libro['isbn']); ?></td>
                                    <td><?php echo htmlspecialchars($libro['ano_publicacion']); ?></td>
                                    <td><?php echo htmlspecialchars($libro['idioma']); ?></td>
                                    <td><?php echo htmlspecialchars($libro['numero_paginas']); ?></td>
                                    <td class="text-center">
                                        <a href="editar.php?id_libro=<?php echo urlencode($libro['id_libro']); ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="eliminar.php?id_libro=<?php echo urlencode($libro['id_libro']); ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
                                           Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    No hay libros registrados en este momento.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

