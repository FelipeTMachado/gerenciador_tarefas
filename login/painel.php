<?php
    include('paginaInacessivel.php');

    if(!isset($_SESSION)) {
        session_start();
    }

    include '/var/www/html/principal/principal.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="./style.css" />
</head>
<body>
    <h1>Usuario, <?php echo $_SESSION['nome']; ?></h1>

    <a href="logout.php">Logout</a>
</body>
</html>