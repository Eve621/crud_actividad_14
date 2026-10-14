<?php
$editar = $pelicula->getId() !== null;

$generos = [
    "Acción", "Animación", "Aventura", "Ciencia ficción", "Comedia",
    "Documental", "Drama", "Fantasía", "Misterio", "Romance",
    "Suspenso", "Terror"
];

// géneros que ya tiene la película (guardados separados por coma)
$generosMarcados = [];
if ($pelicula->getGenero() != "") {
    $generosMarcados = explode(", ", $pelicula->getGenero());
}
// si tiene un género que no está en la lista, se agrega para no perderlo
foreach ($generosMarcados as $g) {
    if (!in_array($g, $generos)) {
        $generos[] = $g;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editar ? "Editar película" : "Nueva película" ?></title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

<div class="contenedor formulario">

    <h1><?= $editar ? "Editar película" : "Nueva película" ?></h1>

    <form method="POST"
          onsubmit="return validarGeneros(this)"
          action="index.php?accion=<?= $editar ? "actualizar" : "guardar" ?>">

        <?php if ($editar): ?>
            <input type="hidden" name="id" value="<?= $pelicula->getId() ?>">
        <?php endif; ?>

        <label for="nombre">Nombre:</label>
        <input type="text"
               id="nombre"
               name="nombre"
               maxlength="100"
               required
               value="<?= htmlspecialchars($pelicula->getNombre()) ?>">

        <label>Géneros (máximo 3):</label>
        <div class="opciones-genero">
            <?php foreach ($generos as $genero): ?>
                <label>
                    <input type="checkbox"
                           name="genero[]"
                           value="<?= htmlspecialchars($genero) ?>"
                           <?= in_array($genero, $generosMarcados) ? "checked" : "" ?>>
                    <?= htmlspecialchars($genero) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <label for="duracion">Duración (minutos):</label>
        <input type="number"
               id="duracion"
               name="duracion"
               min="1"
               required
               value="<?= $pelicula->getDuracion() ?>">

        <label for="imagenportada">Imagen de portada (ruta o enlace):</label>
        <input type="text"
               id="imagenportada"
               name="imagenportada"
               maxlength="255"
               value="<?= htmlspecialchars($pelicula->getImagenportada()) ?>">

        <div class="acciones-formulario">
            <a href="index.php" class="btn btn-cancelar">Cancelar</a>

            <button type="submit" class="btn btn-guardar">
                <?= $editar ? "Actualizar" : "Guardar" ?>
            </button>
        </div>

    </form>
</div>

<script src="public/js/generos.js"></script>
</body>
</html>
