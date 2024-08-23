<?php
include 'config.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Obtén el ID del juego desde la URL
$juego_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($juego_id <= 0) {
    die("ID de juego inválido.");
}

// Obtén los detalles del juego
$sql = "SELECT * FROM juegos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $juego_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Juego no encontrado.");
}

$juego = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($juego['nombre']); ?></title>
</head>
<body>
    <h2><?php echo htmlspecialchars($juego['nombre']); ?></h2>
    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($juego['descripcion']); ?></p>
    <p><strong>Fecha de Lanzamiento:</strong> <?php echo htmlspecialchars($juego['fecha_lanzamiento']); ?></p>
    <p><strong>Género:</strong> <?php echo htmlspecialchars($juego['genero']); ?></p>

    <form action="juego_procesar.php" method="post">
        <input type="hidden" name="juego_id" value="<?php echo htmlspecialchars($juego['id']); ?>">
        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
        <input type="submit" value="Comprar">
    </form>

    <a href="juegos.php">Volver a la lista de juegos</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
