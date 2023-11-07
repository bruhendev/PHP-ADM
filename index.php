<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    use Core\ConfigController;

    require './vendor/autoload.php';

    $home = new ConfigController();
    $home->loadPage();

    ?>
</body>

</html>