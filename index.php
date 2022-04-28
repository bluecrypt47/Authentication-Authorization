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
    if (isset($_SESSION['email'])) {
        echo '<h1 align="center">Welcome ' . $_SESSION['email'] . "!</h1>";
        echo '<a href="logout.php" class="btn" >Logout</a> <br \>';
        //  upload file 
        echo '<a href="upload.php" class="btn" >Upload</a>';
    } else {
        echo '<script> window.location="login.php";</script>';
    }
    ?>

    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'xss');

    $sql = "SELECT * FROM upload";
    $result = mysqli_query($conn, $sql);

    $files = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <!-- Search
    <div align="center">
        <form action="search.php" method="get">
            Search: <input type="text" name="search" />
            <input type="submit" name="ok" value="search" />
        </form>
    </div> -->


    <table>
        <thead>
            <th>No.</th>
            <th>Filename</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($files as $file) : ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $file['name']; ?></td>
                    <td><a class="btn btn-primary" href="fileDetail.php?filename=<?php echo $file['name'] ?>">View</a> |
                        <a class="btn btn-primary" href="index.php?filename=<?php echo $file['name'] ?>">Download</a>
                    </td>

                </tr>
            <?php endforeach; ?>


        </tbody>
    </table>

</body>

</html>