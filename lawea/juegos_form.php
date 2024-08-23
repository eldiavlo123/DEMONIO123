<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Juego</title>
</head>
<body>
    <h2>Agregar Nuevo Juego</h2>
    <form action="juegos_procesar.php" method="post">
        <input type="hidden" name="id" value="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>
        <label for="fecha_lanzamiento">Fecha de Lanzamiento:</label>
        <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" required><br><br>
        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" required><br><br>
        <input type="submit" value="Agregar">
    </form>

    <a href="juegos.php">Volver a la lista de juegos</a>
</body>
</html>
