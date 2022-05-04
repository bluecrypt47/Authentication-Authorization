<?php
require 'handle.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

    <?php
    if (isset($_GET['idUser'])) {
        $id = $_GET['idUser'];

        // fetch file to download from database
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        $account = mysqli_fetch_assoc($result);
    }
    ?>

    <?php if (isset($_REQUEST['submit'])) {
        $password = $_REQUEST['password'];
        $username = $_REQUEST['username'];
        $role = $_REQUEST['role'];

        if (!empty($username) && !empty($password)) {
            $email =  $_SESSION['email'];
            $update = "UPDATE users SET username='$username',password='$password',role='$role' WHERE email='$email'";
            $result = mysqli_query($conn, $update);
            echo '<script language="javascript">alert("Update Successfully!"); window.location="index.php";</script>';
        } else {
            echo '<script language="javascript">alert("Update Fail!"); window.location="editAccount.php?idUser=' . $id . '";</script>';
        }
    } ?>
    <h2>Account</h2>
    <form action="editAccount.php" method="post" class="form">
        <label for="email">Email: </label>
        <input type="email" name="email" placeholder="Email" value="<?php echo $account['email']; ?>" required disabled /> <br>

        <label for="password">Password: </label>
        <input type="password" name="password" placeholder="Password" value="<?php echo $account['password']; ?>" required /><br>

        <label for="username">Username: </label>
        <input type="text" name="username" placeholder="username" value="<?php echo $account['username']; ?>" required><br>
        <input type="hidden" name="role" placeholder="Role" value="<?php echo $account['role']; ?>" required><br>

        <input type="submit" name="submit" value="Update" style="background: #4CAF50;" />
    </form>
    <a href="index.php" class="btn btn-primary">Back home</a>

</body>

</html>