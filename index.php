<?php session_start() ?>
<?php require 'handle.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dash Board</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 100px auto;
        }

        th,
        td {
            height: 50px;
            vertical-align: center;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php


    $email = $_SESSION['email'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);



    if (isset($user['id'])) {
        echo '<h1 align="center">Welcome ' . $user['username'] . "!</h1>";
        echo '<a href="logout.php" class="btn" >Logout</a> <br \>';
        //  upload file 
        echo '<a href="upload.php" class="btn" >Upload</a>';
        // Edit account
        echo '<a href="editAccount.php?idUser=' . $user['id'] . '" class="btn" >Account</a> <br \>';
    } else {
        echo '<script> window.location="login.php";</script>';
    }
    ?>

    <?php
    $sql = "SELECT * FROM upload";
    $result = mysqli_query($conn, $sql);

    $files = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <?php
    if ($user['role'] == 1) { ?>

        <table>
            <thead>
                <th>No.</th>
                <th>Filename</th>
                <th>Action</th>
                <th>Author</th>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($files as $file) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $file['name']; ?></td>
                        <td><?php echo $file['email']; ?></td>
                        <td><a class="btn btn-primary" href="fileDetail.php?filename=<?php echo $file['name'] ?>">View</a> |
                            <a class="btn btn-primary" href="index.php?f=<?php echo $file['name'] ?>">Download</a> |
                            <a class="btn btn-primary" href="readFile.php?readFile=<?php echo $file['name'] ?>">Read</a>
                        </td>

                    </tr>
                <?php endforeach; ?>


            </tbody>
        </table>
    <?php } else {
        echo '<h2>You not role to see File!</h2>';
    } ?>
</body>

</html>