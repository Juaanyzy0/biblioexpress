<?php
require_once "conexion.php";

// Recibimos el id_libro enviado por GET
$id_libro = isset($_GET['id_libro']) ? $_GET['id_libro'] : "";

// Validamos que exista y que sea un número entero positivo
if (!is_numeric($id_libro) || (int)$id_libro <= 0) {
    header("Location: index.php?error=" . urlencode("ID de libro inválido para eliminar."));
    exit;
}

try {
    // Eliminamos el registro usando una sentencia preparada
    $sql = "DELETE FROM libro WHERE id_libro = :id_libro";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_libro' => (int)$id_libro]);

    header("Location: index.php?mensaje=" . urlencode("Libro eliminado correctamente."));
    exit;
} catch (PDOException $e) {
    header("Location: index.php?error=" . urlencode("Error al eliminar el libro: " . $e->getMessage()));
    exit;
}
?>

