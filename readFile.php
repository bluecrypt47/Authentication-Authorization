<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read file</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <a href="index.php" class="btn btn-primary">Back home</a> <br /><br />
    <?php
    if (isset($_GET['readFile'])) {
        $filename = './uploads/' . $_GET['readFile'];
        $fp = fopen($filename, "r");

        $contents = fread($fp, filesize($filename));

        echo "<pre>$contents</pre>";
        fclose($fp);
    }
    ?>
</body>

</html>