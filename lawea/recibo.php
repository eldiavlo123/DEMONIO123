<?php
include 'config.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Obtén el ID de la compra desde la URL
$compra_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($compra_id <= 0) {
    die("ID de compra inválido.");
}

// Obtén los detalles de la compra
$sql = "SELECT c.id, c.juego_id, j.nombre AS juego_nombre, c.usuario_id, u.username AS usuario_nombre
        FROM compras c
        JOIN juegos j ON c.juego_id = j.id
        JOIN usuarios u ON c.usuario_id = u.id
        WHERE c.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $compra_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Compra no encontrada.");
}

$compra = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Compra</title>
</head>
<body>
    <h2>Recibo de Compra</h2>
    <p><strong>ID de Compra:</strong> <?php echo htmlspecialchars($compra['id']); ?></p>
    <p><strong>Juego:</strong> <?php echo htmlspecialchars($compra['juego_nombre']); ?></p>
    <p><strong>Usuario:</strong> <?php echo htmlspecialchars($compra['usuario_nombre']); ?></p>
    <p><a href="juegos.php">Volver a la lista de juegos</a></p>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
