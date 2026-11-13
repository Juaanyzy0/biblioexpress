<?php
require_once "conexion.php";

// Verificamos que la petición venga por método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Limpiamos espacios en blanco al inicio y al final con trim()
    $titulo          = isset($_POST['titulo']) ? trim($_POST['titulo']) : "";
    $isbn            = isset($_POST['isbn']) ? trim($_POST['isbn']) : "";
    $ano_publicacion = isset($_POST['ano_publicacion']) ? (int) $_POST['ano_publicacion'] : 0;
    $idioma          = isset($_POST['idioma']) ? trim($_POST['idioma']) : "";
    $numero_paginas  = isset($_POST['numero_paginas']) ? (int) $_POST['numero_paginas'] : 0;

    // 1. Validamos que los campos de texto no estén vacíos
    if ($titulo === "" || $isbn === "" || $idioma === "") {
        header("Location: index.php?error=" . urlencode("Todos los campos son obligatorios."));
        exit;
    }

    // 2. Validamos que el año sea mayor a 1500 y las páginas mayores a 0
    if ($ano_publicacion <= 1500 || $numero_paginas <= 0) {
        header("Location: index.php?error=" . urlencode("El año debe ser mayor a 1500 y el número de páginas mayor a 0."));
        exit;
    }

    try {
        // Preparamos la consulta INSERT usando marcadores con nombre para evitar inyección SQL
        $sql = "INSERT INTO libro (titulo, isbn, ano_publicacion, idioma, numero_paginas) 
                VALUES (:titulo, :isbn, :ano_publicacion, :idioma, :numero_paginas)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'          => $titulo,
            ':isbn'            => $isbn,
            ':ano_publicacion' => $ano_publicacion,
            ':idioma'          => $idioma,
            ':numero_paginas'  => $numero_paginas
        ]);

        // Redirigimos al listado con mensaje de éxito
        header("Location: index.php?mensaje=" . urlencode("Libro registrado correctamente."));
        exit;

    } catch (PDOException $e) {
        header("Location: index.php?error=" . urlencode("Error al guardar el libro: " . $e->getMessage()));
        exit;
    }
} else {
    // Si intentan entrar directamente a guardar.php por la URL, los enviamos al inicio
    header("Location: index.php");
    exit;
}
?>

