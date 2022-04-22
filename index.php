<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION['email'])) {
        echo '<h1 align="center">Welcome ' . $_SESSION['email'] . "!</h1>";
        echo '<a href="logout.php" class="btn" >Logout</a> <br \>';
    } else {
        echo '<script> window.location="login.php";</script>';
    }
    ?>

</body>

</html>