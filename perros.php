<?php
require_once "funciones.php";

$raza = strtolower(trim($_GET["raza"] ?? ""));
if ($raza === "") {
    $url = "https://dog.ceo/api/breeds/image/random";
} else {
    $url = "https://dog.ceo/api/breed/" 
         . urlencode($raza) 
         . "/images/random";
}

$resultado = consumirApiGet($url);
$imagen = null;
$error = null;

if ($resultado["ok"]) {
    $imagen = $resultado["datos"]["message"] ?? null;
} else {
    $error = $resultado["error"];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perro aleatorio</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Dog CEO API</h1>

<form method="GET">
        <label>Raza:</label>
        <input
            type="text"
            name="raza"
            value="<?= htmlspecialchars($raza) ?>"
            placeholder="hound, beagle, pug, husky"
        >

        <button type="submit">
            Buscar
        </button>
    </form>
    
    <br>

    <?php if ($error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php elseif ($imagen): ?>
        <img src="<?= htmlspecialchars($imagen) ?>" alt="Perro aleatorio" width="350">
    <?php endif; ?>

    <br><br>
    <a href="perros.php">Mostrar otro perro</a>
</body>
</html>