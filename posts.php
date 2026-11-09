<?php
require_once "funciones.php";

$url = "https://jsonplaceholder.typicode.com/posts?userId=1";
$resultado = consumirApiGet($url);
$posts = [];

if ($resultado["ok"]) {
    $posts = $resultado["datos"];
}

$respuestaCreacion = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $contenido = trim($_POST["contenido"] ?? "");
    if ($titulo !== "" && $contenido !== "") {
        $respuestaCreacion = consumirApiPost(
            "https://jsonplaceholder.typicode.com/posts",
            [
                "title" => $titulo,
                "body" => $contenido,
                "userId" => 1
            ]
        );
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Posts - JSONPlaceholder</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Posts del usuario 1</h1>
    
    <?php foreach (array_slice($posts, 0, 5) as $post): ?>
        <article>
            <h2><?= htmlspecialchars($post["title"]) ?></h2>
            <p><?= htmlspecialchars($post["body"]) ?></p>
            <small>ID: <?= $post["id"] ?></small>
        </article>
        <hr>
    <?php endforeach; ?>
    <h2>Crear post de prueba</h2>
    <form method="POST">
        <input
            type="text"
            name="titulo"
            placeholder="Título"
            required
        >
        <br><br>
        <textarea
            name="contenido"
            placeholder="Contenido"
            required
        ></textarea>
        <br><br>
        <button type="submit">
            Enviar a la API
        </button>
    </form>

    <?php if ($respuestaCreacion): ?>
        <h3>Respuesta de la API</h3>
        <p>
            HTTP:
            <?= $respuestaCreacion["codigo"] ?>
        </p>
        <pre>
            <?= htmlspecialchars(
                print_r(
                    $respuestaCreacion["datos"],
                    true
                )
            ) ?>
        </pre>
    <?php endif; ?>
</body>
</html>
