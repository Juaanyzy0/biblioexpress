<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro - BiblioExpress</title>
    <!-- Bootstrap 5 por CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Registrar Nuevo Libro</h2>
                </div>
                <div class="card-body">
                    <!-- El formulario envía los datos por POST a guardar.php -->
                    <form action="guardar.php" method="POST">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del libro *</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ej: El Coronel no tiene quien le escriba" required>
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN *</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Ej: 978-9588886213" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="ano_publicacion" class="form-label">Año de publicación *</label>
                                <input type="number" name="ano_publicacion" id="ano_publicacion" class="form-control" min="1501" placeholder="Ej: 1961" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="idioma" class="form-label">Idioma *</label>
                                <input type="text" name="idioma" id="idioma" class="form-control" placeholder="Ej: Español" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="numero_paginas" class="form-label">N° de páginas *</label>
                                <input type="number" name="numero_paginas" id="numero_paginas" class="form-control" min="1" placeholder="Ej: 112" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="index.php" class="btn btn-secondary">Cancelar y volver</a>
                            <button type="submit" class="btn btn-success">Guardar Libro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

