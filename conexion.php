<?php
// Variables de configuración
$driver    = "mysql"; // Cambiar a "pgsql" si se usa PostgreSQL
$servidor  = "localhost";
$puerto    = "3306"; // En PostgreSQL normalmente es "5432"
$basedatos = "biblio_express";
$usuario   = "estudiante";
$password  = "sena1234";

// Armamos el DSN
if ($driver === "mysql") {
    $dsn = "mysql:host=$servidor;port=$puerto;dbname=$basedatos;charset=utf8mb4";
} else {
    $dsn = "pgsql:host=$servidor;port=$puerto;dbname=$basedatos";
}

try {
    // Creamos la instancia de PDO y activamos las excepciones para detectar errores SQL
    $pdo = new PDO($dsn, $usuario, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Si falla la conexión, detenemos la ejecución y mostramos el motivo
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>

