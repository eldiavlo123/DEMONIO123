<?php
include 'config.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Verifica que los datos del formulario estén presentes
if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['fecha_lanzamiento'], $_POST['genero'])) {
    $juego_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_lanzamiento = $_POST['fecha_lanzamiento'];
    $genero = $_POST['genero'];

    // Verifica que los campos no estén vacíos
    if (empty($nombre) || empty($descripcion) || empty($fecha_lanzamiento) || empty($genero)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Procesa la inserción o actualización de los datos del juego
    if ($juego_id > 0) {
        // Actualizar juego existente
        $sql = "UPDATE juegos SET nombre = ?, descripcion = ?, fecha_lanzamiento = ?, genero = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $descripcion, $fecha_lanzamiento, $genero, $juego_id);
    } else {
        // Insertar nuevo juego
        $sql = "INSERT INTO juegos (nombre, descripcion, fecha_lanzamiento, genero) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $descripcion, $fecha_lanzamiento, $genero);
    }

    if ($stmt->execute()) {
        header('Location: juegos.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    die("Error: Datos del formulario no válidos.");
}

$conn->close();
?>
