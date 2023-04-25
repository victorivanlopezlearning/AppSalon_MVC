<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón - <?php echo isset($titulo) ? $titulo : ''; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css"> <!--Se ingresa diagonal al inicio de la ruta para que empiece a buscar desde la raiz del proyecto -->
</head>
<body>
    <div class="contenedor-app">
        <div class="imagen"></div>

        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>

    <?php 
        echo $script ?? '';
    ?>
</body>
</html>