<?php
$conn = mysqli_connect('localhost', 'root', '', 'xss');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Detail</title>

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
    if (isset($_GET['filename'])) {
        $name = $_GET['filename'];

        // fetch file to download from database
        $sql = "SELECT * FROM upload WHERE name='$name'";
        $result = mysqli_query($conn, $sql);

        $files = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    ?>
    <h2 align="center"> <b>Details</b> </h2>
    <a class="btn btn-lg  " href="index.php"><b>Home</b></a>
    <table>
        <thead>
            <th>Filename</th>
            <th>Size(MB)</th>
            <th>Author</th>
        </thead>
        <tbody>
            <?php foreach ($files as $file) : ?>
                <tr>
                    <td><?php echo $file['name']; ?></td>
                    <td><?php echo $file['size'] / 1000 . "KB"; ?></td>
                    <td><?php echo $file['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2> Comment </h2>
    <form method="POST">
        <textarea name="content" style="width: 60%; margin-left: 200px;" rows="5" placeholder="Write comment here..."></textarea><br />
        <input type="submit" value="Send" name="submit" class="btn btn-primary" style="margin-left: 200px;">
    </form>
    <br />
    <?php
    if (isset($_POST['content'])) {
        $content = $_POST['content'];
        $filename = $_GET['filename'];

        if (empty($content)) {
            echo '<script language="javascript">alert("Enter comment, pls!"); window.location="fileDetail.php";</script>';
        } elseif ($filename == '') {
            echo '<script language="javascript">alert("You have not commented!"); window.location="fileDetail.php";</script>';
        } elseif (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];

            $sql = "INSERT INTO comments (filename, email, content) VALUES ('$filename','$email','$content')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                $result = mysqli_error($conn);
            }
        }
    }
    ?>
    <?php
    $filename = $_GET['filename'];

    $sql = "SELECT * FROM comments where filename = '$filename'";
    $result = mysqli_query($conn, $sql);

    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <div style="margin-left: 200px;">
        <?php foreach ($comments as $comment) : ?>

            <?php echo $comment['creDate']; ?>:
            <b><?php echo $comment['email']; ?></b> :
            <?php echo $comment['content']; ?> <br />

        <?php endforeach; ?>
    </div>
    <br />
</body>

</html>