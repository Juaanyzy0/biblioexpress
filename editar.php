<?php
require_once "conexion.php";

$error_formulario = "";

// Si el formulario fue enviado por POST, procesamos la actualización (UPDATE)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_libro        = isset($_POST['id_libro']) ? (int) $_POST['id_libro'] : 0;
    $titulo          = isset($_POST['titulo']) ? trim($_POST['titulo']) : "";
    $isbn            = isset($_POST['isbn']) ? trim($_POST['isbn']) : "";
    $ano_publicacion = isset($_POST['ano_publicacion']) ? (int) $_POST['ano_publicacion'] : 0;
    $idioma          = isset($_POST['idioma']) ? trim($_POST['idioma']) : "";
    $numero_paginas  = isset($_POST['numero_paginas']) ? (int) $_POST['numero_paginas'] : 0;

    // Validamos datos antes de actualizar
    if ($titulo === "" || $isbn === "" || $idioma === "") {
        $error_formulario = "Todos los campos son obligatorios.";
    } elseif ($ano_publicacion <= 1500 || $numero_paginas <= 0) {
        $error_formulario = "El año debe ser mayor a 1500 y las páginas mayores a 0.";
    } else {
        try {
            $sql = "UPDATE libro 
                    SET titulo = :titulo, 
                        isbn = :isbn, 
                        ano_publicacion = :ano_publicacion, 
                        idioma = :idioma, 
                        numero_paginas = :numero_paginas 
                    WHERE id_libro = :id_libro";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo'          => $titulo,
                ':isbn'            => $isbn,
                ':ano_publicacion' => $ano_publicacion,
                ':idioma'          => $idioma,
                ':numero_paginas'  => $numero_paginas,
                ':id_libro'        => $id_libro
            ]);

            header("Location: index.php?mensaje=" . urlencode("Libro actualizado correctamente."));
            exit;
        } catch (PDOException $e) {
            $error_formulario = "Error al actualizar: " . $e->getMessage();
        }
    }
}

// Obtenemos el id_libro por GET (o del POST si hubo un error de validación)
$id_libro = isset($_GET['id_libro']) ? $_GET['id_libro'] : (isset($_POST['id_libro']) ? $_POST['id_libro'] : "");

// Validamos que el ID sea numérico
if (!is_numeric($id_libro) || (int)$id_libro <= 0) {
    header("Location: index.php?error=" . urlencode("ID de libro no válido."));
    exit;
}

// Consultamos los datos actuales del libro con sentencia preparada
$stmt = $pdo->prepare("SELECT * FROM libro WHERE id_libro = :id_libro");
$stmt->execute([':id_libro' => (int)$id_libro]);
$libro = $stmt->fetch();

// Si el libro no existe en la base de datos, regresamos al listado
if (!$libro) {
    header("Location: index.php?error=" . urlencode("El libro solicitado no existe."));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro - BiblioExpress</title>
    <!-- Bootstrap 5 por CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h2 class="h5 mb-0">Editar Libro #<?php echo htmlspecialchars($libro['id_libro']); ?></h2>
                </div>
                <div class="card-body">

                    <?php if ($error_formulario !== ""): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error_formulario); ?>
                        </div>
                    <?php endif; ?>

                    <form action="editar.php?id_libro=<?php echo urlencode($libro['id_libro']); ?>" method="POST">
                        <!-- Campo oculto con el ID del libro -->
                        <input type="hidden" name="id_libro" value="<?php echo htmlspecialchars($libro['id_libro']); ?>">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del libro *</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" 
                                   value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN *</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" 
                                   value="<?php echo htmlspecialchars($libro['isbn']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="ano_publicacion" class="form-label">Año de publicación *</label>
                                <input type="number" name="ano_publicacion" id="ano_publicacion" class="form-control" min="1501"
                                       value="<?php echo htmlspecialchars($libro['ano_publicacion']); ?>" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="idioma" class="form-label">Idioma *</label>
                                <input type="text" name="idioma" id="idioma" class="form-control" 
                                       value="<?php echo htmlspecialchars($libro['idioma']); ?>" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="numero_paginas" class="form-label">N° de páginas *</label>
                                <input type="number" name="numero_paginas" id="numero_paginas" class="form-control" min="1"
                                       value="<?php echo htmlspecialchars($libro['numero_paginas']); ?>" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

