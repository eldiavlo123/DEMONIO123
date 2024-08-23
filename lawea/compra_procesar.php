<?php
include 'config.php';

// Verifica si el usuario está autenticado
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Obtén datos del formulario
$juego_id = isset($_POST['juego_id']) ? intval($_POST['juego_id']) : 0;
$usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : 0;

if (!$juego_id || !$usuario_id) {
    die("Datos de compra inválidos.");
}

// Inserta la compra en la base de datos
$sql = "INSERT INTO compras (juego_id, usuario_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $juego_id, $usuario_id);

if ($stmt->execute()) {
    $compra_id = $stmt->insert_id; // Obtén el ID de la compra recién insertada
    echo "Compra realizada con éxito. <a href='recibo.php?id=$compra_id'>Ver recibo</a> | <a href='juegos.php'>Volver a la lista de juegos</a>";
} else {
    echo "Error al realizar la compra: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
