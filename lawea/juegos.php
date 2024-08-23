<?php
include 'config.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Obtén la lista de juegos
$sql = "SELECT id, nombre, descripcion FROM juegos";
$result = $conn->query($sql);

// Verifica si la consulta fue exitosa
if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Juegos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .game {
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 200px;
            position: relative;
            text-align: left;
        }
        .game-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .game-description {
            font-size: 14px;
            color: #555;
        }
        a {
            text-decoration: none;
            color: #000;
        }
        a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <h2>Lista de Juegos</h2>
    <a href="juegos_form.php">Agregar Nuevo Juego</a>
    <div class="gallery">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="game">
            <a href="juego_detalle.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                <div class="game-title"><?php echo htmlspecialchars($row['nombre']); ?></div>
                <div class="game-description"><?php echo htmlspecialchars($row['descripcion']); ?></div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
