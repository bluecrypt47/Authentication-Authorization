<?php
if (!isset($_SESSION)) {
    session_start();
}
header('Content-Type: text/html; charset=utf-8');
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'xss') or die('Connection fail!');
mysqli_set_charset($conn, "utf8");

// Login
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];


    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Two password do not match");
    }

    // Kiểm tra email và password có trong DB không
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $sql);

    // Nếu kết quả trả về lớn hơn 1 thì nghĩa là username hoặc email đã tồn tại trong CSDL
    if (mysqli_num_rows($result) > 0) {
        if (!empty($_POST['remember'])) {
            setcookie('login', $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
            setcookie('password', $_POST['password'], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE['login'])) {
                setcookie('login', "");
            }
            if (isset($_COOKIE['password'])) {
                setcookie('password', "");
            }
        }

        echo '<script language="javascript">alert("Login Successfully!"); window.location="index.php";</script>';
    } else {
        echo '<script language="javascript">alert("Email has existed!"); window.location="login.php";</script>';
        die();
    }
    $_SESSION['email'] = $email;
    echo "Xin chào " . $_SESSION['email'];
    die();
}

// Register
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];


    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Two password do not match");
    }

    // Kiểm tra username hoặc email có bị trùng hay không
    $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $sql);

    // Nếu kết quả trả về lớn hơn 1 thì nghĩa là username hoặc email đã tồn tại trong CSDL
    if (mysqli_num_rows($result) > 0) {
        echo '<script language="javascript">alert("Email or username has existed!"); window.location="register.php";</script>';
        // Dừng chương trình
        die();
    } else {
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username','$password','$email')";
        echo '<script language="javascript">alert("Register Successfully!"); window.location="login.php";</script>';

        if (mysqli_query($conn, $sql)) {
            echo "Tên đăng nhập: " . $_POST['username'] . "<br/>";
            echo "Mật khẩu: " . $_POST['password'] . "<br/>";
            echo "Email đăng nhập: " . $_POST['email'] . "<br/>";
        } else {
            echo '<script language="javascript">alert("Register Fail!"); window.location="register.php";</script>';
        }
    }
}

//Upload file
if (isset($_POST['upload'])) {

    // lay thong tin file upload
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $email = $_SESSION['email'];
    $destination = './uploads/' . $name;

    $extension = pathinfo($name, PATHINFO_EXTENSION);

    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];


    if (move_uploaded_file($file, $destination)) {
        $sql = "INSERT INTO upload (name, size, email) VALUES ('$name',  $size, '$email')";

        if (mysqli_query($conn, $sql)) {
            echo '<script language="javascript">alert("Upload file Successfully!"); window.location="index.php";</script>';
        } else {
            echo '<script language="javascript">alert("Upload file Fail!"); window.location="upload.php";</script>';
            die();
        }
    }
}

//Download
if (isset($_GET['filename'])) {
    $file = $_GET['filename'];

    header("Expires: 0");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $basename = pathinfo($file, PATHINFO_BASENAME);

    header("Content-type: application/" . $ext);
    header('Content-length: ' . filesize($file));
    header("Content-Disposition: attachment; filename=\"$basename\"");
    ob_clean();
    flush();
    readfile($file);
}
